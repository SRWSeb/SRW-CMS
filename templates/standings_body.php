<tbody>
  <?php foreach ($s->standings as $driver_key => $driver): ?>
    <tr>

      <th scope="row"><?=$driver['position']; ?></th>
      <td><a href="driverinfo.php?id=<?=$driver['driverID']; ?>&season=<?=$s->season['id']; ?>"><?=$driver['name']; ?></td>
      <?php if($s->season['classes'] == 1): ?>
        <td><?=$classes[$driver['class']]['class_name']?></td>
      <?php endif; ?>
      <td><?=$driver['car']?></td>
      <?php for($i = 0; $i < $s->season['rounds']*$s->season['races_per_round']; $i++): ?>
        <td style="color:<?=$driver['rounds'][$i]['text-color']?>"><?=$driver['rounds'][$i]['pts']?></td>
      <?php endfor; ?>
      <td style="background-color:<?=$driver['inc_color']?>"><?=$driver['total_inc']?></td>
      <td><?=$driver['total_pts']?></td>
    </tr>
  <?php endforeach; ?>
  <?php foreach ($s->disqualified as $dq_key => $dq): ?>
    <tr>
      <th scope="row" style="background-color:#ff0000">DQ</th>
      <td><a href="driverinfo.php?id=<?=$dq['driverID']?>&season=<?=$s->season['id']?>"><?=$dq['name']?></td>
      <?php if($s->season['classes'] == 1): ?>
        <td><?=$classes[$dq['class']]['class_name']?></td>
      <?php endif; ?>
      <td><?=$dq['car']?></td>
      <?php for($i = 0; $i < $s->season['rounds']*$s->season['races_per_round']; $i++): ?>
        <td><?=$dq['rounds'][$i]['pts']?></td>
      <?php endfor; ?>
      <td style="background-color:<?=$dq['inc_color']?>"><?=$dq['total_inc']?></td>
      <td><?=$dq['total_pts']?></td>
    </tr>
  <?php endforeach; ?>
</tbody>
</table>
</div>
