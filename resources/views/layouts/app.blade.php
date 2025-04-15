<!DOCTYPE html>
<html lang="en">
    <head>

        <?php vlx_set_social_meta() ?>
        <?php vlx_set_page_meta() ?>

        {{-- <link rel="stylesheet" href="/css/toastr.css?{{ time() }}"> --}}
        <link rel="stylesheet" href="/css/notyf.min.css?{{ time() }}">
        <link rel="stylesheet" href="/css/core.css?{{ time() }}">
        <link rel="stylesheet" href="/css/account.css?{{ time() }}">
        <link rel="stylesheet" href="/css/blocks.css?{{ time() }}">
        <link rel="icon" type="image/x-icon" href="/favicon.ico">


        <script src="/js/app.js?v=1.0"></script>
        <script src="/js/jquery.min.js?v=3.7.1"></script>

        {{-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-YBKBS0EKY7"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-YBKBS0EKY7');
        </script> --}}

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
                                type: 'warning',
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

    </body>
</html>
