<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Title</title>
  <link href="/css/app.css" rel="stylesheet">
  <!-- HTML5 shim 和 Respond.js 是为了让 IE8 支持 HTML5 元素和媒体查询（media queries）功能 -->
  <!-- 警告：通过 file:// 协议（就是直接将 html 页面拖拽到浏览器中）访问页面时 Respond.js 不起作用 -->
  <!--[if lt IE 9]>
  <script src="https://cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
  <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
  <style>
    .show-title {
      text-align: center;
      font-size: 32px;
      font-weight: 500;
    }

    .show-date {
      text-align: right;
    }

    .show-content {
      font-size: 18px;
      word-break: break-word;
    }
  </style>
</head>
<body>

  @yield('app')

</body>

  @yield('scripts')

</html>