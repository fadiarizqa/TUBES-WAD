<!DOCTYPE html>
<html>
<head>
    <title>Carikeun</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .sidebar-item {
                    display: flex;
                    padding: 12px 20px;
                    align-items: center;
                    gap: 12px;
                    align-self: stretch;
                    cursor: pointer;
                    transition: all 0.2s ease;
                    color: #374151;
                    text-decoration: none;
                    margin: 0.25rem 0.75rem;
                    border-radius: 0.5rem;
                    font-size: 14px;
                    line-height: 22px;
                    letter-spacing: 0.042px;
        }

        .sidebar-item:hover {
            background-color: #f3f4f6;
            color: #1f2937;
        }
        .sidebar-item.active {
            background-color: #080F2B;
            color: #FFF;
            font-weight: 500;
            box-shadow: 0 2px 4px -1px rgba(59, 130, 246, 0.4);
        }
        .sidebar-item.active:hover {
            background-color: #080F2B;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        *{
            box-sizing: border-box;
        }

        .form-login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
       }

       .form-container{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        gap: 24px;
        width: 540px;
        background: #ffffff;
        padding: 32px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        width: 100%;
        max-width: 400px;
       }
      
        .header-text{
        color: #111111;
        text-align: center;
        font-size: 28px;
        font-weight: 600px;
        line-height: 120%;
        letter-spacing: -0.56px;
        width: 100%;
        }

        .form-group{
            width:100%;
        }

        .form-label {
        font-size: 16px;
        font-weight: 500;
        line-height: 120%;
        text-align: left;
        width: 100%;
        }

        /* Input field */
        .input-field {
        width: 100%;
        margin-top: 8px;
        padding: 10px 12px;
        font-family: inherit;
        border-radius: 12px;
        font-size: 16px;
        
        outline: none;
  
        }
        .button-submit {
            padding: 12px 20px;
            align-items: center;
            justify-content: center;
            display: flex;
            border-radius: 100px;
            background: #080F2B;
            color: #FFF;
            font-size: 16px;
            font-weight: 500;
            line-height: 22px;
            letter-spacing: 0.042px;
            font-family: inherit;
            width: 100%;
            cursor: pointer;

        }
    </style>
</head>
<body>
    <div class="flex-layout">
        @include('components.sidebar')

        <div class="main-content">
            @include('components.navbar')

            <div class="p-6">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
