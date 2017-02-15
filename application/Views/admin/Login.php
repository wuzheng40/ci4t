<!DOCTYPE html>
<html>
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- Site Properties -->
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/semantic');?>/components/reset.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/semantic');?>/components/site.css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/semantic');?>/components/container.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/semantic');?>/components/grid.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/semantic');?>/components/header.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/semantic');?>/components/image.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/semantic');?>/components/menu.css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/semantic');?>/components/divider.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/semantic');?>/components/segment.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/semantic');?>/components/form.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/semantic');?>/components/input.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/semantic');?>/components/button.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/semantic');?>/components/list.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/semantic');?>/components/message.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/semantic');?>/components/icon.css">

    <script src="<?php echo base_url('asset/js');?>/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url('vendor/semantic');?>/components/form.js"></script>
    <script src="<?php echo base_url('vendor/semantic');?>/components/transition.js"></script>

    <style type="text/css">
      body {
        background-color: #DADADA;
      }
      body > .grid {
        height: 100%;
      }
      .image {
        margin-top: -100px;
      }
      .column {
        max-width: 450px;
      }
    </style>
    <script>
    $(document)
      .ready(function() {
        $('.ui.form')
          .form({
            fields: {
              email: {
                identifier  : 'email',
                rules: [
                  {
                    type   : 'empty',
                    prompt : 'Please enter your e-mail'
                  },
                  {
                    type   : 'email',
                    prompt : 'Please enter a valid e-mail'
                  }
                ]
              },
              password: {
                identifier  : 'password',
                rules: [
                  {
                    type   : 'empty',
                    prompt : 'Please enter your password'
                  },
                  {
                    type   : 'length[6]',
                    prompt : 'Your password must be at least 6 characters'
                  }
                ]
              }
            }
          })
        ;
      })
    ;
    </script>
</head>
<body>

<div class="ui middle aligned center aligned grid">
    <div class="column">
        <h2 class="ui teal image header">
          <img src="<?php echo base_url('asset/img');?>/logo.png" class="image">
          <div class="content">
            Log-in to your account
          </div>
        </h2>
        <form class="ui large form">
          <div class="ui stacked segment">
            <div class="field">
              <div class="ui left icon input">
                <i class="user icon"></i>
                <input type="text" name="email" placeholder="E-mail address">
              </div>
            </div>
            <div class="field">
              <div class="ui left icon input">
                <i class="lock icon"></i>
                <input type="password" name="password" placeholder="Password">
              </div>
            </div>
            <div class="ui fluid large teal submit button">Login</div>
          </div>

          <div class="ui error message"></div>

        </form>

        <div class="ui message">
          Any Issure? <a href="#">QA</a>
        </div>
    </div>
</div>

</body>

</html>