<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - JurnalKu</title>
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
            max-width: 1100px;
            width: 100%;
            min-height: 650px;
            backdrop-filter: blur(10px);
        }

        .left-section {
            flex: 1.2;
            background: linear-gradient(135deg, #ff6b9d 0%, #ff8a9b 25%, #ffa8a8 50%, #ffb7c5 75%, #ffc7e8 100%);
            padding: 80px 50px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .workspace-illustration {
            width: 350px;
            height: 250px;
            margin-bottom: 40px;
            position: relative;
        }

        .desk {
            width: 100%;
            height: 25px;
            background: linear-gradient(45deg, #e91e63, #f06292);
            border-radius: 15px;
            position: absolute;
            bottom: 50px;
            box-shadow: 0 8px 25px rgba(233, 30, 99, 0.3);
        }

        .monitor {
            width: 100px;
            height: 75px;
            background: linear-gradient(145deg, #2c3e50, #34495e);
            border-radius: 8px;
            position: absolute;
            bottom: 75px;
            left: 50%;
            transform: translateX(-50%);
            border: 4px solid #1a252f;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .monitor::before {
            content: '';
            width: 80px;
            height: 55px;
            background: linear-gradient(45deg, #ff6b9d, #ff8a9b);
            border-radius: 5px;
            position: absolute;
            top: 8px;
            left: 50%;
            transform: translateX(-50%);
        }

        .lamp {
            width: 20px;
            height: 50px;
            background: linear-gradient(180deg, #ffd700, #ffed4e);
            border-radius: 25px;
            position: absolute;
            bottom: 75px;
            right: 50px;
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.5);
        }

        .lamp::before {
            content: '';
            width: 12px;
            height: 12px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            position: absolute;
            top: 8px;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
        }

        .plant {
            width: 25px;
            height: 35px;
            background: linear-gradient(180deg, #27ae60, #2ecc71);
            border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
            position: absolute;
            bottom: 75px;
            left: 40px;
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
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
            width: 80px;
            height: 80px;
            top: 30px;
            left: 30px;
            animation: float 6s ease-in-out infinite;
            background: rgba(255, 182, 193, 0.2);
        }

        .circle:nth-child(2) {
            width: 50px;
            height: 50px;
            top: 80px;
            right: 40px;
            animation: float 4s ease-in-out infinite reverse;
            background: rgba(255, 105, 180, 0.2);
        }

        .circle:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 120px;
            right: 80px;
            animation: float 5s ease-in-out infinite;
            background: rgba(255, 160, 210, 0.2);
        }

        .circle:nth-child(4) {
            width: 40px;
            height: 40px;
            bottom: 200px;
            left: 50px;
            animation: float 7s ease-in-out infinite reverse;
            background: rgba(255, 192, 203, 0.15);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-25px) scale(1.05); }
        }

        .left-section h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            letter-spacing: -0.5px;
        }

        .left-section p {
            font-size: 1.1rem;
            opacity: 0.95;
            text-align: center;
            line-height: 1.7;
            max-width: 300px;
            text-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }

        .right-section {
            flex: 1;
            padding: 80px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: linear-gradient(135deg, #fafafa 0%, #ffffff 100%);
        }

        .form-container h2 {
            color: #2d3748;
            margin-bottom: 40px;
            font-size: 2.2rem;
            font-weight: 700;
            text-align: center;
            background: linear-gradient(135deg, #ff6b9d, #e91e63);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .form-group {
            margin-bottom: 30px;
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 18px 25px 18px 55px;
            border: 2px solid #f1f3f4;
            border-radius: 15px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            background: #ffffff;
            box-shadow: 0 2px 10px rgba(255, 107, 157, 0.1);
        }

        .form-group input:focus {
            outline: none;
            border-color: #ff6b9d;
            background: white;
            box-shadow: 0 0 0 4px rgba(255, 107, 157, 0.1), 0 5px 20px rgba(255, 107, 157, 0.15);
            transform: translateY(-2px);
        }

        .form-group i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #ff6b9d;
            font-size: 1.2rem;
        }

        .btn-login {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #ff6b9d 0%, #e91e63 50%, #c2185b 100%);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 15px;
            box-shadow: 0 8px 25px rgba(255, 107, 157, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(255, 107, 157, 0.4);
            background: linear-gradient(135deg, #e91e63 0%, #c2185b 50%, #ad1457 100%);
        }

        .register-link {
            text-align: center;
            margin-top: 30px;
            color: #6c757d;
            font-size: 1rem;
        }

        .register-link a {
            color: #ff6b9d;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .register-link a:hover {
            color: #e91e63;
            text-decoration: underline;
        }

        .error-message {
            background: linear-gradient(135deg, #ffe6e6, #ffcccc);
            color: #c53030;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            border-left: 4px solid #e53e3e;
            box-shadow: 0 5px 15px rgba(229, 62, 62, 0.1);
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
            }
            
            .left-section {
                padding: 50px 30px;
                min-height: 350px;
            }
            
            .right-section {
                padding: 50px 30px;
            }
            
            .workspace-illustration {
                width: 250px;
                height: 180px;
            }
            
            .left-section h1 {
                font-size: 2.2rem;
            }
            
            .form-container h2 {
                font-size: 1.8rem;
            }
            
            .form-group input {
                padding: 16px 22px 16px 50px;
            }
        }

        @media (max-width: 480px) {
            .left-section {
                padding: 40px 20px;
            }
            
            .right-section {
                padding: 40px 20px;
            }
            
            .left-section h1 {
                font-size: 1.8rem;
            }
            
            .left-section p {
                font-size: 1rem;
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
            </div>
            <div class="workspace-illustration">
                <div class="desk"></div>
                <div class="monitor"></div>
                <div class="lamp"></div>
                <div class="plant"></div>
            </div>
            <h1>Welcome Back!</h1>
            <p>Sign in to access your journal dashboard<br>and continue your journey</p>
        </div>
        
        <div class="right-section">
            <div class="form-container">
                <h2>Sign In</h2>
                
                @if ($errors->any())
                    <div class="error-message">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    
                    <button type="submit" class="btn-login">
                        Sign In <i class="fas fa-arrow-right" style="margin-left: 10px;"></i>
                    </button>
                </form>
                
                <div class="register-link">
                    Don't have an account? <a href="{{ route('register') }}">Register</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>