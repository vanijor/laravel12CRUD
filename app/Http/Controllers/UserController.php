<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Listar os usuários
    public function index(Request $request)
    {
        // Recuperar os registros do banco dados
        // $users = User::orderByDesc('id')->paginate(10);
        $users = User::when(
            $request->filled('name'),
            fn($query) =>
            $query->whereLike('name', "%" . $request->name . '%')
        )
            ->when(
                $request->filled('email'),
                fn($query) =>
                $query->whereLike('email', "%" . $request->email . '%')
            )
            ->when(
                $request->filled('start_date_registration'),
                fn($query) =>
                $query->where('created_at', '>=', Carbon::parse($request->start_date_registration))
            )
            ->when(
                $request->filled('end_date_registration'),
                fn($query) =>
                $query->where('created_at', '<=', Carbon::parse($request->end_date_registration))
            )
            ->orderByDesc('id')
            ->paginate(7)
            ->withQueryString();

        // Carregar a VIEW
        return view('users.index', [
            'users' => $users,
            'name' => $request->name,
            'email' => $request->email,
            'start_date_registration' => $request->start_date_registration,
            'end_date_registration' => $request->end_date_registration
        ]);
    }

    // Detalhes do usuario
    public function show(User $user)
    {
        // Carregar a VIEW
        return view('users.show', ['user' => $user]);
    }

    // Carregar o formulário cadastrar novo usuário
    public function create()
    {
        // Carregar a VIEW
        return view('users.create');
    }

    // Cadastrar no banco de dados o novo registro
    public function store(UserRequest $request)
    {
        // dd($request);

        try {

            // Cadastrar no banco de dados na tabela usuários
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('users.show', ['user' => $user->id])->with('success', 'Usuário cadastrado com sucesso!');
        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Usuário não cadastrado!');
        }
    }

    // Carregar o formulário editar usuário
    public function edit(User $user)
    {
        // Carregar a VIEW
        return view('users.edit', ['user' => $user]);
    }

    // Editar no banco de dados o usuário
    public function update(UserRequest $request, User $user)
    {

        try {
            // Editar as informações do registro no banco de dados
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('users.show', ['user' => $user->id])->with('success', 'Usuário editado com sucesso!');
        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Usuário não editado!');
        }
    }

    // Carregar o formulário editar senha do usuário
    public function editPassword(User $user)
    {

        // Carregar a VIEW
        return view('users.editPassword', ['user' => $user]);
    }

    // Editar no banco de dados a senha do usuário
    public function updatePassword(Request $request, User $user)
    {

        // Validar o formulário
        $request->validate([
            'password' => 'required|min:6',
        ], [
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos :min caracteres.',
        ]);

        try {

            // Editar as informações do registro no banco de dados
            $user->update([
                'password' => $request->password,
            ]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('users.show', ['user' => $user->id])->with('success', 'Senha do usuário editada com sucesso!');
        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Senha do usuário não editada!');
        }
    }

    public function destroy(User $user)
    {
        try {
            // Deletar o registro do banco de dados
            $user->delete();
            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso');
        } catch (Exception $e) {
            // Redirecionar o usuário, enviar a mensagem de erro
            return redirect()->route('users.index')->with('error', 'Usuário não excluído!');
        }
    }
    /* Gerar PDF */
    public function generatePdf(User $user)
    {

        // Carregar a string com o HTML/conteudo e determinar a orientação e o tamanho do arquivo
        $pdf = Pdf::loadView('users.generate-pdf', ['user' => $user])->setPaper('a4', 'portrait');

        //Fazer o download do arquivo
        return $pdf->download('view_user.pdf');
    }
    /* Gerar PDF da Lista */
    public function generatePdfUsers(Request $request)
    {
        try {
            // Recuperar os registros do banco dados
            $users = User::when(
                $request->filled('name'),
                fn($query) =>
                $query->whereLike('name', "%" . $request->name . '%')
            )
                ->when(
                    $request->filled('email'),
                    fn($query) =>
                    $query->whereLike('email', "%" . $request->email . '%')
                )
                ->when(
                    $request->filled('start_date_registration'),
                    fn($query) =>
                    $query->where('created_at', '>=', Carbon::parse($request->start_date_registration))
                )
                ->when(
                    $request->filled('end_date_registration'),
                    fn($query) =>
                    $query->where('created_at', '<=', Carbon::parse($request->end_date_registration))
                )
                ->orderByDesc('name')
                ->get();

            //Somar total de regitros
            $totalRecords = $users->count('id');

            //Verifica se a quantidade de registros ultrapassa o limite para gerar PDF
            $numberRecordsAllowed = 20;
            if ($totalRecords > $numberRecordsAllowed) {
                // Redirecionar o usuário, enviar a mensagem de erro
                return redirect()->route('users.index', [
                    'name' => $request->name,
                    'email' => $request->email,
                    'start_date_registration' => $request->start_date_registration,
                    'end_date_registration' => $request->end_date_registration
                ])->with('error', "Limite de registros ultrapassado para gerar PDF. O limite é de $numberRecordsAllowed registros!");
            }

            //Carregar a string com o HTML/conteúdo e determinar a orintação e o tamanho do arquivo
            $pdf = Pdf::loadView('users.generate-pdf-users', ['users' => $users])->setPaper('a4', 'portrait');

            // Fazer o download do arquivo
            return $pdf->download('listar_usuarios.pdf');
        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return redirect()->route('users.index', [
                'name' => $request->name,
                'email' => $request->email,
                'start_date_registration' => $request->start_date_registration,
                'end_date_registration' => $request->end_date_registration
            ])->with('error', 'PDF não gerado!');
        }
    }
}
