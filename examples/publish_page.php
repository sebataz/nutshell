<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Example Page</title>
  </head>
  <body>
      <h3>Responder::request($_controller_name)->get():</h3>
      <code><?php var_dump(nutshell\request\Responder::request('Example')->get()); ?></code>
      
      
      <h3>Responder::request($_controller_name)->post():</h3>
      <code><?php var_dump(nutshell\request\Responder::request('Example')->post()); ?></code>
      
      <h3>Responder::request($_controller_name)->publish():</h3>
      <code>$GetVariable: <?php echo $GetVariable; ?></code><br />
      <code>$PostVariable: <?php echo $PostVariable; ?></code>
      
      <h2>post some data</h2>
      <form action='' method='post'>
          <input type='text' name='post' value='<?php echo $PostVariable; ?>' />
          <input type='submit' />
      </form>
  </body>
</html>
