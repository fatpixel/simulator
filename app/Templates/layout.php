<!doctype html>
<html class="no-js" lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= $this->e($title) ?></title>

  <link rel="stylesheet" href="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.css" rel='stylesheet' type='text/css'>
</head>
<body>

<div class="callout primary">
  <div class="row medium-10 large-8 columns">
    <h3 class="left"><?= $this->e($title) ?></h3>

    <a class="button small warning" id="advance" href="/advance">Advance Time (1 Hr)</a>
    <a class="button small success" id="feed" href="/feed">Feed the Zoo</a>

    <h5><?= $this->e($hours) ?> Hours Passed</h5>

  </div>
</div>

<?= $this->section('content') ?>

<div class="row medium-10 large-8 text-right columns">
  <a class="button small" id="reset" href="/reset">Reset the Zoo</a>
</div>


<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.js"></script>
<script>
  $(document).foundation();
</script>



</body>
</html>