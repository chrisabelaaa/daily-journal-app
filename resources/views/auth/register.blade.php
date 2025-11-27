<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - JurnalKu</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 50%, #fecfef 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            display: flex;
            background: white;
            border-radius: 25px;
            box-shadow: 0 25px 80px rgba(255, 154, 158, 0.15);
            overflow: hidden;
            max-width: 1200px;
            width: 100%;
            min-height: 700px;
            backdrop-filter: blur(10px);
        }

        .left-section {
            flex: 1.2;
            background: linear-gradient(135deg, #ff6b9d 0%, #ff8a9b 25%, #ffa8a8 50%, #ffb7c5 75%, #ffc7e8 100%);
            padding: 100px 60px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .workspace-illustration {
            width: 380px;
            height: 280px;
            margin-bottom: 50px;
            position: relative;
        }

        .desk {
            width: 100%;
            height: 30px;
            background: linear-gradient(45deg, #e91e63, #f06292);
            border-radius: 18px;
            position: absolute;
            bottom: 60px;
            box-shadow: 0 10px 30px rgba(233, 30, 99, 0.3);
        }

        .monitor {
            width: 120px;
            height: 90px;
            background: linear-gradient(145deg, #2c3e50, #34495e);
            border-radius: 10px;
            position: absolute;
            bottom: 90px;
            left: 50%;
            transform: translateX(-50%);
            border: 5px solid #1a252f;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .monitor::before {
            content: '';
            width: 100px;
            height: 70px;
            background: linear-gradient(45deg, #ff6b9d, #ff8a9b);
            border-radius: 6px;
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .lamp {
            width: 25px;
            height: 60px;
            background: linear-gradient(180deg, #ffd700, #ffed4e);
            border-radius: 30px;
            position: absolute;
            bottom: 90px;
            right: 60px;
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.5);
        }

        .lamp::before {
            content: '';
            width: 15px;
            height: 15px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
        }

        .plant {
            width: 30px;
            height: 40px;
            background: linear-gradient(180deg, #27ae60, #2ecc71);
            border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
            position: absolute;
            bottom: 90px;
            left: 50px;
            box-shadow: 0 8px 20px rgba(39, 174, 96, 0.3);
        }

        .decorative-elements {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(5px);
        }

        .circle:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 40px;
            left: 40px;
            animation: float 6s ease-in-out infinite;
            background: rgba(255, 182, 193, 0.2);
        }

        .circle:nth-child(2) {
            width: 60px;
            height: 60px;
            top: 100px;
            right: 50px;
            animation: float 4s ease-in-out infinite reverse;
            background: rgba(255, 105, 180, 0.2);
        }

        .circle:nth-child(3) {
            width: 80px;
            height: 80px;
            bottom: 150px;
            right: 100px;
            animation: float 5s ease-in-out infinite;
            background: rgba(255, 160, 210, 0.2);
        }

        .circle:nth-child(4) {
            width: 50px;
            height: 50px;
            bottom: 250px;
            left: 60px;
            animation: float 7s ease-in-out infinite reverse;
            background: rgba(255, 192, 203, 0.15);
        }

        .circle:nth-child(5) {
            width: 70px;
            height: 70px;
            top: 200px;
            left: 20px;
            animation: float 8s ease-in-out infinite;
            background: rgba(255, 218, 235, 0.2);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-30px) scale(1.08); }
        }

        .left-section h1 {
            font-size: 3.2rem;
            font-weight: 700;
            margin-bottom: 25px;
            text-align: center;
            text-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
            letter-spacing: -0.8px;
        }

        .left-section p {
            font-size: 1.15rem;
            opacity: 0.95;
            text-align: center;
            line-height: 1.8;
            max-width: 350px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .right-section {
            flex: 1;
            padding: 80px 70px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: linear-gradient(135deg, #fafafa 0%, #ffffff 100%);
        }

        .form-container h2 {
            color: #2d3748;
            margin-bottom: 45px;
            font-size: 2.4rem;
            font-weight: 700;
            text-align: center;
            background: linear-gradient(135deg, #ff6b9d, #e91e63);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .form-group {
            margin-bottom: 28px;
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 20px 28px 20px 58px;
            border: 2px solid #f1f3f4;
            border-radius: 16px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            background: #ffffff;
            box-shadow: 0 3px 12px rgba(255, 107, 157, 0.08);
        }

        .form-group input:focus {
            outline: none;
            border-color: #ff6b9d;
            background: white;
            box-shadow: 0 0 0 4px rgba(255, 107, 157, 0.12), 0 8px 25px rgba(255, 107, 157, 0.15);
            transform: translateY(-3px);
        }

        .form-group i {
            position: absolute;
            left: 22px;
            top: 50%;
            transform: translateY(-50%);
            color: #ff6b9d;
            font-size: 1.3rem;
        }

        .btn-register {
            width: 100%;
            padding: 20px;
            background: linear-gradient(135deg, #ff6b9d 0%, #e91e63 50%, #c2185b 100%);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
            box-shadow: 0 10px 30px rgba(255, 107, 157, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .btn-register:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 40px rgba(255, 107, 157, 0.4);
            background: linear-gradient(135deg, #e91e63 0%, #c2185b 50%, #ad1457 100%);
        }

        .login-link {
            text-align: center;
            margin-top: 35px;
            color: #6c757d;
            font-size: 1.05rem;
        }

        .login-link a {
            color: #ff6b9d;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
            color: #e91e63;
            text-decoration: underline;
        }

        .error-message {
            background: linear-gradient(135deg, #ffe6e6, #ffcccc);
            color: #c53030;
            padding: 18px 25px;
            border-radius: 14px;
            margin-bottom: 28px;
            border-left: 5px solid #e53e3e;
            box-shadow: 0 6px 18px rgba(229, 62, 62, 0.12);
            font-weight: 500;
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .container {
                flex-direction: column;
                margin: 0;
                min-height: auto;
                border-radius: 20px;
                max-width: none;
            }
            
            .left-section {
                padding: 60px 40px;
                min-height: 400px;
            }
            
            .right-section {
                padding: 60px 40px;
            }
            
            .workspace-illustration {
                width: 280px;
                height: 200px;
            }
            
            .left-section h1 {
                font-size: 2.4rem;
            }
            
            .form-container h2 {
                font-size: 2rem;
            }
            
            .form-group input {
                padding: 18px 25px 18px 52px;
            }
        }

        @media (max-width: 480px) {
            .left-section {
                padding: 50px 25px;
            }
            
            .right-section {
                padding: 50px 25px;
            }
            
            .left-section h1 {
                font-size: 2rem;
            }
            
            .left-section p {
                font-size: 1rem;
            }
            
            .form-container h2 {
                font-size: 1.8rem;
            }
            
            .workspace-illustration {
                width: 220px;
                height: 160px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-section">
            <div class="decorative-elements">
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
            </div>
            <div class="workspace-illustration">
                <div class="desk"></div>
                <div class="monitor"></div>
                <div class="lamp"></div>
                <div class="plant"></div>
            </div>
            <h1>Save Your Account Now</h1>
            <p>Get unlimited type of forms, questions and responsed,<br>Free forever</p>
        </div>
        
        <div class="right-section">
            <div class="form-container">
                <h2>Create Account</h2>
                
                @if ($errors->any())
                    <div class="error-message">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    
                    <div class="form-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                    </div>
                    
                    <button type="submit" class="btn-register">
                        Sign Up <i class="fas fa-arrow-right" style="margin-left: 10px;"></i>
                    </button>
                </form>
                
                <div class="login-link">
                    Already have an account? <a href="{{ route('login') }}">Login</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>