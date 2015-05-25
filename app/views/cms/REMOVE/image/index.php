<?php
/* @var $this ImageController */
/* @var $model Image */
?>

<h1>Images</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'image-grid',
	'cssFile' => 'false',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'selectableRows'=>1,
	'selectionChanged'=>'function(id){
		location.href = "'.$this->createUrl('update').'/id/"+$.fn.yiiGridView.getSelection(id);
	}',
	'columns' => array(
		array(
			'header' => 'Preview',
			'type' => 'raw',
			'value' => 'CHtml::image(Utils::imageUrl("flux".DS.$data->thumb), $data->title, array("width"=>45))',
		),
		'title',
		array(
			'name' => 'date_created',
			'value' => 'Utils::date($data->date_created)',
		),
		array(
			'name' => 'date_updated',
			'value' => '$data->date_updated != $data->date_created ? Utils::date($data->date_updated) : "never"',
		),
		array(
			'class' => 'CButtonColumn',
			'template' => '{publish}{unpublish}{update}{delete}',
			'buttons' => array(
				'publish' => array(
					'label'=>'Unpublished',
					'url'=>'array("cms/image/publish", "id"=>$data->id)',
					'imageUrl'=>_bu('/images/publish.png'),
					'visible'=>'$data->status == 0',
					'click'=>'js:function(){
						if(!confirm("Are you sure you want to publish this item?")) return false;
						var th = this,
						afterDelete = function(){};
						$("#image-grid").yiiGridView("update", {
							type: "POST",
							url: $(this).attr("href"),
							success: function(data) {
								$("#image-grid").yiiGridView("update");
								afterDelete(th, true, data);
							},
							error: function(XHR) {
								return afterDelete(th, false, XHR);
							}
						});
					}',
				),
				'unpublish' => array(
					'label'=>'Published',
					'url'=>'array("cms/image/unpublish", "id"=>$data->id)',
					'imageUrl'=>_bu('/images/unpublish.png'),
					'visible'=>'$data->status == 1',
					'click'=>'js:function(){
						if(!confirm("Are you sure you want to unpublish this item?")) return false;
						var th = this,
						afterDelete = function(){};
						$("#image-grid").yiiGridView("update", {
							type: "POST",
							url: $(this).attr("href"),
							success: function(data) {
								$("#image-grid").yiiGridView("update");
								afterDelete(th, true, data);
							},
							error: function(XHR) {
								return afterDelete(th, false, XHR);
							}
						});
					}',
				),
				'update' => array(
					'imageUrl'=>_bu('/images/update.png'),
				),
				'delete' => array(
					'imageUrl'=>_bu('/images/delete.png'),
				),
			),
		),
	),
	'pager' => array(
		'cssFile' => false,
		'header' => '',
		'firstPageLabel' => '&laquo;',
		'prevPageLabel' => '&lsaquo;',
		'nextPageLabel' => '&rsaquo;',
		'lastPageLabel' => '&raquo;',
	),
));

echo CHtml::link('Add image', array('cms/image/create'), array('class'=>'button'));