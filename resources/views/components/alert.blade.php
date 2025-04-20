@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                title: "Pronto!",
                text: "{{ session('success') }}",
                icon: "success"
            });
        })
    </script>
@endif
@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                title: "Erro!",
                text: "{{ session('error') }}",
                icon: "error"
            });
        })
    </script>
@endif
@if ($errors->any())
    @php
        $message = '';
        foreach ($errors->all() as $error) {
            $message .= $error . '<br>';
        }
    @endphp
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                title: "Erro!",
                html: "{!! $message !!}",
                icon: "error"
            });
        })
    </script>
@endif
