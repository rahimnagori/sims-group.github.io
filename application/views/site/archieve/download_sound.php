<div class="table-responsive">
  <table class="table">
    <thead>
      <tr>
        <th>S.No.</th>
        <th>Sound</th>
        <th>Credit Required</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $totalCredit = 0;
        foreach($downloadSounds as $serialNumber => $downloadSound){
          $totalCredit += $downloadSound['credit_amount'];
      ?>
          <tr>
            <td><?=$serialNumber + 1;?></td>
            <td><?=$downloadSound['sound_title'];?></td>
            <td><?=round($downloadSound['credit_amount'], 0);?></td>
          </tr>
      <?php
        }
      ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="2">Total Credit Required</th>
        <th><?=$totalCredit;?></th>
      </tr>
    </tfoot>

  </table>
</div>
<div id="responseMessage"></div>