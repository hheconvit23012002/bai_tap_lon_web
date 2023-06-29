<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>Register | Hyper - Responsive Bootstrap 4 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">

    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/app-creative.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/app-creative-dark.min.css') }}" rel="stylesheet" type="text/css">

</head>

<body class="authentication-bg pb-0" data-layout-config='{"darkMode":false}'>

<div class="auth-fluid">
    <!--Auth fluid left content -->
    <div class="auth-fluid-form-box">
        <div class="align-items-center d-flex h-100">
            <div class="card-body">
                <!-- title-->
                <h4 class="mt-0">Free Sign Up</h4>
                <p class="text-muted mb-4">Don't have an account? Create your account, it takes less than a minute
                </p>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <!-- form -->
                <form action="{{ route('registering') }}" method="post" id="form-register" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="fullname">Full Name</label>
                        <input class="form-control" type="text" id="name" placeholder="Enter your name"
                               required name="name">
                    </div>
                    <div class="form-group">
                        <label for="emailaddress">Email address</label>
                        <input class="form-control" type="email" id="email" required
                               placeholder="Enter your email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control" type="password" required id="password"
                               placeholder="Enter your password" name="password">
                    </div>
                    <div class="form-group">
                        <label>Avatar</label>
                        <input
                            name="avatar"
                            accept="image/*"
                            class="form-control "
                            type='file' id="imgInp"/>
                        <img id="blah"
                                 src="#"
                             alt="your image"
                             class="rounded-circle" width="100"/>
                    </div>

                    <div class="form-group mb-0 text-center">
                        <button class="btn btn-primary btn-block" type="submit" onclick="submitForm()">
                             Sign Up
                        </button>
                    </div>
                </form>
                <!-- end form-->

                <!-- Footer-->
                <footer class="footer footer-alt">
                    <p class="text-muted">Already have account? <a href="{{ route('login') }}"
                                                                   class="text-muted ml-1"><b>Log In</b></a></p>
                </footer>
            </div> <!-- end .card-body -->
        </div> <!-- end .align-items-center.d-flex.h-100-->
    </div>
    <!-- end auth-fluid-form-box-->

    <!-- Auth fluid right content -->
    <div class="auth-fluid-right text-center">
        <div class="auth-user-testimonial">
            <p>
                Huan Nguyen Danh
            </p>
        </div> <!-- end auth-user-testimonial-->
    </div>
    <!-- end Auth fluid right content -->
</div>
<!-- end auth-fluid-->

<!-- bundle -->
<script src="{{ asset('js/vendor.min.js') }}"></script>
<script src="{{ asset('js/app.min.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    imgInp.onchange = evt => {
        const [file] = imgInp.files
        if (file) {
            blah.src = URL.createObjectURL(file)
        }
    }

    function validateEmail(email) {
        let emailPattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        return emailPattern.test(email);
    }

    function submitForm() {
        event.preventDefault();
        if($("#email").val() === "" || $("#password").val() === "" || $("#name").val() === ""){
            alert("Tên, Email và password không được để trống")
        }
        else if(validateEmail($("#email").val()) === false){
            alert("Nhập đúng định dạng email")
        }else{
            $("#form-register").submit();
        }
    }



</script>
</body>

</html>
