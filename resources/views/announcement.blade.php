<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Announcement</title>
<style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 40px;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            
            
        }
        .back-arrow {
  position: absolute;
  left: 50;
  top: 10%;
  transform: translateY(-50%);
  font-size: 24px;
  text-decoration: none;
  color: #333;
  cursor: pointer;
  padding: 8px;
}

.back-arrow:hover {
  color: #8b4513;}
        h1 {
            color: #222;
        }
        textarea {
            width: 100%;
            height: 120px;
            padding: 15px;
            border: 1px solid #aaa;
            border-radius: 10px;
            resize: none;
            box-sizing: border-box;
        }
        button {
            margin-top: 15px;
            padding: 10px 25px;
            border: none;
            border-radius: 6px;
            background:#ab6005;
            cursor: pointer;
        }
        .success {
            color: green;
            margin-bottom: 15px;
        }
        .error {
            color: red;
            margin-bottom: 15px;

        input{
              border: 1px solid #aaa;
            border-radius: 10px;
            resize: none;
            box-sizing: border-box
        }
        }
    </style>
</head>
<body>

<div class="container">
    <a href="javascript:history.back()" class="back-arrow" aria-label="Go back">
    &#8592;
  </a>
    <h1>SHEREHE MANAGEMENT SYSTEM</h1>
    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif
    <form action="{{ route('announcement.store') }}" method="POST">
        @csrf
        <textarea
            name="content"
            placeholder="Write announcement here..."
            required ></textarea>
            <input type="date" name="date">
        <br>

        <button type="submit">
            Post
        </button>

    </form>

</div>

</body>
</html>
