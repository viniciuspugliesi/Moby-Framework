<!DOCTYPE html>
<html>
<head>
    <title>Moby Error</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" 
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        
    <link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond:300" rel="stylesheet">
    
    <style>
        .primary-error{
            padding: 2px 15px;
            border-color: rgb(165, 29, 29);
        }
        .primary-error div{
            font-size: 17px;
        }
        h1{
            font-family: 'Cormorant Garamond', serif;
            color: #4290bf;
            color: #000;
            font-size: 80px;
            text-shadow: 0.8px 0.5px 0.1px #000;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <h1>Moby Error</h1>
            
            <div class="panel panel-danger primary-error">
                <div class="panel-body">
                    <b>Message:</b> <?= $args->getMessage() ?> <b>File: </b> <?= $args->getFile() ?> <b>Line:</b> <?= $args->getLine() ?> <b>Code: </b> <?= $args->getCode() ?> 
                </div>
            </div>
            
            <br>
            
            <?php if (method_exists($args, 'getTrace')): ?>
                <h3>All errors: </h3>
                <ul class="list-group">
                    <?php foreach ($args->getTrace() as $trace): ?>
                        <?php if (isset($trace['file']) || isset($trace['line'])): ?>
                            <li class="list-group-item">
                                <?= isset($trace['file']) ? '<b>Error in file: </b>' . $trace['file'] : ''; ?>
                                <?= isset($trace['line']) ? '<b>in line: </b>'. $trace['line'] : ''; ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        
        <div class="jumbotron">
            <h2>Do you need help?</h2>
            <p>Access the Moby documentation or Moby Forum.</p>
            <p>
              <a class="btn btn-lg btn-primary" href="http://doc.mobyframework.com/Errors/Code/<?= $args->getCode() ?>" role="button">Documentation »</a>
              <a class="btn btn-lg btn-info" href="http://forum.mobyframework.com/Errors/Code/<?= $args->getCode() ?>" role="button">Forum »</a>
            </p>
        </div>
    </div>
</body>
</html>