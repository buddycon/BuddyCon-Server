<?php
/**
 * TbThumbnails class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 */

Yii::import('bootstrap.widgets.TbListView');

/**
 * Bootstrap thumbnails widget.
 * @see http://twitter.github.com/bootstrap/components.html#thumbnails
 */
class TbThumbnails extends TbListView
{
	/**
	 * Renders the data items for the view.
	 * Each item is corresponding to a single data model instance.
	 * Child classes should override this method to provide the actual item rendering logic.
	 */
	public function renderItems()
	{
		echo CHtml::openTag($this->itemsTagName,array('class'=>$this->itemsCssClass))."\n";
		
		$data = $this->dataProvider->getData();
		
		if (!empty($data))
		{
			echo CHtml::openTag('ul', array('class'=>'thumbnails'));
			$owner = $this->getOwner();
			$render = $owner instanceof CController ? 'renderPartial' : 'render';
			foreach($data as $i=>$item)
			{
				$data = $this->viewData;
				$data['index'] = $i;
				$data['data'] = $item;
				$data['widget'] = $this;
				$owner->$render($this->itemView,$data);
			}

			echo '</ul>';
		}
		else
			$this->renderEmptyText();
		
		echo CHtml::closeTag($this->itemsTagName);

	}

    /*public function run(){
        parent::run();
        echo "<script type=\"text/javascript\">
         $(document).ready(function() {
            $('.delete').click(function() {
        var btn = $(this);
        btn.button('loading'); // call the loading function
        $.ajax({
            url: '".Yii::app()->createUrl('screen/delete')."&t=0&id='+btn.attr('id'),
            success: function(data) {
                window.open('http://imgur.com/delete/'+btn.attr('id'));
                btn.toggle();
                $('#li'+btn.attr('id')).toggle();
            }
        });
    });
    $('.deletet').click(function() {
        var btn = $(this);
        btn.button('loading'); // call the loading function
        $.ajax({
            url: '".Yii::app()->createUrl('screen/delete')."&t=1&id='+btn.attr('id'),
            success: function(data) {
                btn.toggle();
                $('#li'+btn.attr('id')).toggle();
            }
        });
    });
    });
    </script>
        ";
    }*/
}
