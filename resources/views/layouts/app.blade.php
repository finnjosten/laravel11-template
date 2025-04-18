<!DOCTYPE html>
<html lang="en">
    <head>

        @include('layouts.partials.meta')
        @include('layouts.partials.styles')

        <script src="/js/app.js?v=1.0"></script>
        <script src="/js/jquery.min.js?v=3.7.1"></script>
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

        @stack('styles')
        @yield('head')

    </head>
    <body class="show-nav-@yield('show-nav', 'true')">
        @include('components.navbar')
        @yield('content')

        <div class="vlx-toast">
            <script src="/js/notyf.min.js"></script>
            {{-- <script src="/js/toastr.js?v=2.1.1"></script> --}}

            <script>
                if (isNotyfAvailable()) {
                    var notyf = new Notyf({
                        duration: 5000,
                        position: {
                            x: 'center',
                            y: 'bottom',
                        },
                        dismissible: false,
                        ripple: true,
                        types: [
                            {
                                type: 'info',
                                background: '#2f2f2f',
                                icon: {
                                    className: 'vlx-icon vlx-icon--square-info',
                                    tagName: 'i',
                                    color: '#3498db',
                                },
                            },
                            {
                                type: 'success',
                                background: '#2f2f2f',
                                icon: {
                                    className: 'vlx-icon vlx-icon--square-check',
                                    tagName: 'i',
                                    color: '#2ecc71',
                                },
                            },
                            {
                                type: 'warn',
                                background: '#2f2f2f',
                                icon: {
                                    className: 'vlx-icon vlx-icon--square-exclamation',
                                    tagName: 'i',
                                    color: '#f1c40f',
                                },
                            },
                            {
                                type: 'error',
                                background: '#2f2f2f',
                                icon: {
                                    className: 'vlx-icon vlx-icon--square-xmark',
                                    tagName: 'i',
                                    color: '#e74c3c',
                                },
                            },
                        ]
                    });
                }

                if (isToastrAvailable()) {
                    toastr.options = {
                        "positionClass": "toast-top-right",
                        "timeOut": "5000",
                        "extendedTimeOut": "5000",
                        "preventDuplicates": true,
                        "toastrTextFontFamily": "Poppins",
                        "progressBar": true,
                    };
                }
            </script>
            <script>
                @if (session()->has('info'))
                    toastInfo("{{ session()->get('info') }}");
                @endif
                @if (session()->has('success'))
                    toastSuccess("{{ session()->get('success') }}");
                @endif
                @if (session()->has('warning'))
                    toastWarning("{{ session()->get('warning') }}");
                @endif
                @if (session()->has('error'))
                    toastError("{{ session()->get('error') }}");
                @endif
            </script>
        </div>

        @stack('scripts')

    </body>
</html>
