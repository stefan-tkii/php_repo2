<?php if(isset($_POST['Register'])) : ?>
<?php 
    if(count($errors)>0) :  ?>

<div>
    <?php foreach($errors as $err) : ?>
        <P> <?php echo $err ?> </P>
        <?php endforeach ?>
</div>

<?php endif ?>
<?php endif ?>