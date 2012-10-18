<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<?php /* if(isset($this->menu)){?>
<div class="span3">
    <?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'list',
    'items'=>array(
        array('label'=>'OPERATIONS'),
        $this->menu,
        /* array('label'=>'LIST HEADER'),
      array('label'=>'Home', 'icon'=>'home', 'url'=>'#', 'active'=>true),
      array('label'=>'Library', 'icon'=>'book', 'url'=>'#'),
      array('label'=>'Application', 'icon'=>'pencil', 'url'=>'#'),
      array('label'=>'ANOTHER LIST HEADER'),
      array('label'=>'Profile', 'icon'=>'user', 'url'=>'#'),
      array('label'=>'Settings', 'icon'=>'cog', 'url'=>'#'),
      array('label'=>'Help', 'icon'=>'flag', 'url'=>'#'),
    ),
)); ?>
</div>
<div class="span9">
    <?php echo $content; ?>
</div>
 */ ?>

<?php echo $content; ?>

<?php $this->endContent(); ?>