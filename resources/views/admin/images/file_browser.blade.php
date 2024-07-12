<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browser Image</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.24.0/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            var funcNum = {{ $_GET['CKEditorFuncNum'] . ';' }}
            $('#fileExplorer').on('click', 'img', function() {
                var fileUrl = $(this).attr('title');
                window.opener.CKEDITOR.tools.callFunction(funcNum, fileUrl);
                window.close();
            }).hover(function() {
                $(this).css('cursor', 'poiter');
            })
        })
    </script>
    <style>
        .file_list {
            background: #1F568B;
            list-style-type: none;
        }

        .li-img {
            list-style: none;
            float: left;
            width: 150px;
            margin: 10px;
        }

        .li-img:hover {
            cursor: pointer;
        }

        .li-img img {
            height: 100px;
            width: auto;
        }

        .img-name {
            color: black;
            word-wrap: break-word;
        }

        .img-name:hover {
            text-decoration: underline;
        }
    </style>

</head>

<body>
    <div id="fileExplorer">
        @foreach ($fileNames as $file)
            <ul class="file-list">
                <li class="li-img">
                    <img src="{{ asset('/uploads/ckeditor/' . $file) }}" alt=""
                        title="{{ asset('/uploads/ckeditor/' . $file) }}">
                    <br>
                    <span class="img-name">{{ $file }}</span>
                </li>
            </ul>
        @endforeach
    </div>
</body>

</html>
