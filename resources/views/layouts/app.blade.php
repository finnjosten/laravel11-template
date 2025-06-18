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
            @php
                $success = $info = $warning = $error = [];
                $full_stop = false;
                $i = 0;
                while(!$full_stop && $i < 50) {
                    if ($i == 0) {
                        if (session()->has('info')) $info[] = session()->get('info');
                        if (session()->has('success')) $success[] = session()->get('success');
                        if (session()->has('warning')) $warning[] = session()->get('warning');
                        if (session()->has('error')) $error[] = session()->get('error');
                    } else {
                        $info_stop = $suc_stop = $war_stop = $err_stop = false;
                        if (session()->has('info' . $i)) {
                            $info[] = session()->get('info' . $i);
                        } else {
                            $info_stop = true;
                        }

                        if (session()->has('success' . $i)) {
                            $success[] = session()->get('success' . $i);
                        } else {
                            $suc_stop = true;
                        }

                        if (session()->has('warning' . $i)) {
                            $warning[] = session()->get('warning' . $i);
                        } else {
                            $war_stop = true;
                        }

                        if (session()->has('error' . $i)) {
                            $error[] = session()->get('error' . $i);
                        } else {
                            $err_stop = true;
                        }

                        if ($suc_stop && $war_stop && $err_stop && $info_stop) {
                            $full_stop = true;
                        }
                    }
                    $i++;
                }

                echo '<script>';
                foreach($info as $message) {
                    echo 'toastInfo("' . $message . '");';
                }
                foreach($success as $message) {
                    echo 'toastSuccess("' . $message . '");';
                }
                foreach($warning as $message) {
                    echo 'toastWarning("' . $message . '");';
                }
                foreach($error as $message) {
                    echo 'toastError("' . $message . '");';
                }
                echo '</script>';
            @endphp
        </div>

        @stack('scripts')

    </body>
</html>
