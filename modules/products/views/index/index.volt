<!-- /modules/products/views/index.volt -->

<?php echo $this->elements->getTabs(); ?>
<ul class="pager">
  <li class="previous pull-left">
    <?php echo $this->tag->linkTo(array('products/index', '&larr; Go Back')); ?>
  </li>
  <li class="pull-right">
    <?php echo $this->tag->linkTo(array('products/add', 'Create Product')); ?>
  </li>
</ul>

<h1>Products Index</h1>

<div class="form-result-placeholder">
  <?php if (isset($err_msg)) {
    echo $err_msg;
  } ?>
</div>
<?php
echo $this->tag->form(array('action' => 'products/multiple', 'class' => 'form-manage-data')) . "\n";
echo $form->render('csrf', array('value' => $this->security->getToken(), 'data-token-name' => $this->security->getTokenKey())) . "\n";
?>
<table class="table table-bordered table-striped">
  <thead>
  <tr>
    <th></th>
    <th>Id</th>
    <th>Product Type</th>
    <th>Name</th>
    <th>Price</th>
    <th>Active</th>
    <th colspan="2">Action</th>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td colspan="2">
      <button>Select All</button>
    </td>
    <td colspan="6">
      <div class="btn-group">
        <?php echo $this->tag->linkTo(array('products/index', '<i class="icon-fast-backward"></i> First',
          'class' => 'btn btn-default')); ?>
        <?php echo $this->tag->linkTo(array('products/index?page=' . $page->before, '<i
                            class="icon-step-backward"></i> Previous', 'class' => 'btn btn-default')); ?>
      </div>
      <span class="help-inline">We have found <?php echo $page->total_pages; ?>
        pages and right now we are on page <?php echo $page->current; ?></span>

      <div class="btn-group pull-right">
        <?php echo $this->tag->linkTo(array('products/index?page=' . $page->next, '<i
                            class="icon-step-forward"></i> Next', 'class' => 'btn btn-default')); ?>
        <?php echo $this->tag->linkTo(array('products/index?page=' . $page->last, '<i
                            class="icon-fast-forward"></i> Last', 'class' => 'btn btn-default')); ?>
      </div>
    </td>
  </tr>
  </tbody>
  <?php
  if (isset($page->items) && !empty($page->items)) {
    foreach ($page->items as $product) {
      ?>

      <tr>
        <td><?php echo $this->tag->checkField(['id[]', 'value' => $product->id]); ?></td>
        <td><?php echo $product->id; ?></td>
        <td><?php //echo $product->getProductTypes()->name; ?></td>
        <td><?php echo $product->name; ?></td>
        <td><?php echo $product->price; ?></td>
        <td><?php echo $product->getActiveDetail(); ?></td>
      <td
        width="7%"><?php echo $this->tag->linkTo(array('products/edit/' . $product->id, '<i class="glyphicon glyphicon-edit"></i> Edit', 'class' => 'btn btn-default')); ?>
      </td>
      <td
        width="7%"><?php echo $this->tag->linkTo(array('products/delete/' . $product->id, '<i class="glyphicon glyphicon-remove"></i> Delete', 'class' => 'btn btn-default')); ?>
      </td>
      </tr>
    <?php
    }// endforeach;
  ?>
  <tbody>
  <tr>
    <td colspan="2">
      <button type="submit" class="delete-btn">Delete Selected</button>
    </td>
    <td colspan="6">
      <div class="btn-group">
        <?php echo $this->tag->linkTo(array('products/index', '<i class="icon-fast-backward"></i> First',
          'class' => 'btn btn-default')); ?>
        <?php echo $this->tag->linkTo(array('products/index?page=' . $page->before, '<i
                            class="icon-step-backward"></i> Previous', 'class' => 'btn btn-default')); ?>
      </div>
      <span class="help-inline">We have found <?php echo $page->total_pages; ?>
        pages and right now we are on page <?php echo $page->current; ?></span>

      <div class="btn-group pull-right">
        <?php echo $this->tag->linkTo(array('products/index?page=' . $page->next, '<i
                            class="icon-step-forward"></i> Next', 'class' => 'btn btn-default')); ?>
        <?php echo $this->tag->linkTo(array('products/index?page=' . $page->last, '<i
                            class="icon-fast-forward"></i> Last', 'class' => 'btn btn-default')); ?>
      </div>
    </td>
  </tr>
  </tbody>

  <?php
  } else {
    ?>
    <tr>
      <td colspan="5">No data.</td>
    </tr>
  <?php }// endif; ?>
</table>

<?php echo $this->tag->endForm(); ?>
