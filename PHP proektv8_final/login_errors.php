<?php  if(isset($_POST['Login'])) : ?>
    <?php if(count($errors)>0) : ?>
        <div>
    <?php foreach($errors as $err) : ?>
        <P><b> <?php echo $err ?> </b> </P>
        <?php endforeach ?>
    </div>
    <?php endif ?>
<?php endif ?>