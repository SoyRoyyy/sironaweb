<!DOCTYPE html>
<html>
<head>
    <title>Upload Excel</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:700,300" rel="stylesheet">
    <style>

        body {
            margin: 0;
            height: 100vh;
            font-family: "Open Sans", Helvetica, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(-45deg, #1f1c2c, #7495f1, #19224b, #2e1a5f);
            background-size: 400% 400%;
            animation: gradientMove 15s ease infinite;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .frame {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 400px;
            height: 400px;
            margin-top: -200px;
            margin-left: -200px;
            border-radius: 2px;
            box-shadow: 4px 8px 16px 0 rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background: linear-gradient(to top right, darkmagenta 0%, rgb(108, 105, 255) 100%);
            color: #333;
            font-family: "Open Sans", Helvetica, sans-serif;
        }

        .center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            height: 260px;
            border-radius: 3px;
            box-shadow: 8px 10px 15px 0 rgba(0, 0, 0, 0.2);
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            flex-direction: column;
        }

        .title {
            width: 100%;
            height: 50px;
            border-bottom: 1px solid #999;
            text-align: center;
        }

        h1 {
            font-size: 16px;
            font-weight: 300;
            color: #666;
        }

        .dropzone {
            width: 100px;
            height: 100px;
            margin-left: 14%;
            border: 1px dashed #999;
            border-radius: 3px;
            text-align: center;
        }

        .upload-icon {
            margin: 25px 2px 2px 2px;
        }

        .upload-input {
            position: relative;
            top: -62px;
            cursor: pointer;
            width: 100%;
            height: 100%;
            opacity: 0;
        }

        .btn {
            display: block;
            width: 140px;
            height: 40px;
            background: darkmagenta;
            color: #fff;
            border-radius: 3px;
            border: 0;
            box-shadow: 0 3px 0 0 rgb(128, 105, 255);
            transition: all 0.3s ease-in-out;
            font-size: 14px;
            cursor: pointer;
        }

        .btn:hover {
            background: rebeccapurple;
            box-shadow: 0 3px 0 0 rgb(47, 10, 148);
        }

        .success-msg {
            color: green;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="frame">
        <div class="center">
            <div class="title">
                <h1>Drop file to upload</h1>
            </div>

            @if(session('success'))
                <p class="success-msg">{{ session('success') }}</p>
            @endif

            <form action="{{ route('index') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="dropzone">
                    <img src="http://100dayscss.com/codepen/upload.svg" class="upload-icon" />
                    <input type="file" name="file" class="upload-input" required />
                </div>

                <button type="submit" class="btn" name="uploadbutton">Upload file</button>
            </form>
        </div>
    </div>
</body>
</html>
