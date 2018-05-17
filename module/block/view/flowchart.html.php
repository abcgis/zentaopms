<style>
.block-flowchart {padding: 10px;}
.block-flowchart .table {margin-bottom: 0;}
.block-flowchart .table > thead > tr > th,
.block-flowchart .table > tbody > tr > td,
.block-flowchart .table > tbody > tr > th {padding: 10px;font-weight: normal;text-align: center;}
.block-flowchart .table > thead > tr > th:first-child,
.block-flowchart .table > tbody > tr > td:first-child,
.block-flowchart .table > tbody > tr > th:first-child {text-align: left;}
.block-flowchart .table > thead > tr > th {width: 18%;vertical-align: top;}
.block-flowchart .table > thead > tr > th:first-child {width: auto;padding: 10px 10px 15px 10px;background: none;}
.block-flowchart .table > thead > tr > th:first-child + th > div {background: none;}
.block-flowchart .table > thead > tr > th,
.block-flowchart .table > thead > tr > th > div {padding: 0;background: url('data:image/gif;base64,R0lGODlhLQAPAJEAAAAAAP///+7u7v///yH5BAEAAAMALAAAAAAtAA8AAAJPlIY5psn92jrSUGVrRFlfvHHh9JGS6aVQ2K2l+LYOO6KuCpby/No8DjvtgrfiD+gj5ozLpvMIfSanu2FyiKX1qqOsrsaNdbXCcfm8Ok1OBQA7') no-repeat;background-position: right -22px top 15px;}
.block-flowchart .table > thead > tr > th > div {padding: 10px 10px 15px 10px;background-position: left -23px top 15px;}
.block-flowchart .table > thead > tr > th:last-child {background: none;}
.block-flowchart .table > tbody > tr > td {color: #3c4353;}
.block-flowchart .table > tbody > tr:nth-child(even) > td {background: #f7f8f9;}
.block-flowchart .flowchart-title {font-size: 14px;font-weight: bold;color: #3c4353;}
.block-flowchart .flowchart-step {display: inline-block;width: 24px;height: 24px;font-size: 14px;line-height: 24px;color: #fff;background-color: #00a9fc;border-radius: 50%;}
</style>
<table class="table table-borderless">
  <thead>
    <tr>
      <?php for($i = 0; $i < 6; $i++):?>
      <?php if($i == 0):?>
      <th><span class="flowchart-title"><?php echo $lang->block->lblFlowchart?></span></th>
      <?php else:?>
      <th><div><span class="flowchart-step"><?php echo $i?></span></div></th>
      <?php endif;?>
      <?php endfor;?>
    </tr>
  </thead>
  <tbody>
    <?php foreach($lang->block->flowchart as $flowchart):?>
    <tr>
      <?php for($i = 0; $i < 6; $i++):?>
      <?php if($i == 0):?>
      <th><?php echo $flowchart[$i];?></th>
      <?php else:?>
      <td><?php echo zget($flowchart, $i, '')?></td>
      <?php endif;?>
      <?php endfor;?>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>
