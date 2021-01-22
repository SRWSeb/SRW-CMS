<tbody>
  <?php foreach ($s->standings as $driver_key => $driver): ?>
    <tr>

      <th scope="row"><?php echo $driver['position']; ?></th>
      <td><a href="driverinfo.php?id=<?php echo $driver['driverID']; ?>&season=<?php echo $s->season['id']; ?>"><?php echo $driver['name']; ?></td>
      <?php if($s->season['classes'] == 1): ?>
        <td><?php echo $classes[$driver['class']]['class_name'] ?></td>
      <?php endif; ?>
      <td><?php echo $driver['car']; ?></td>
      <?php for($i = 0; $i < $s->season['rounds']*$s->season['races_per_round']; $i++): ?>
        <td><?php echo $driver['rounds'][$i]['pts']; ?></td>
      <?php endfor; ?>
      <td style="background-color:<?php echo $driver['inc_color']; ?>"><?php echo $driver['total_inc']; ?></td>
      <td><?php echo $driver['total_pts']; ?></td>
    </tr>
  <?php endforeach; ?>
  <?php foreach ($s->disqualified as $dq_key => $dq): ?>
    <tr>
      <th scope="row" style="background-color:#ff0000">DQ</th>
      <td><a href="driverinfo.php?id=<?php echo $dq['driverID']; ?>&season=<?php echo $s->season['id']; ?>"><?php echo $dq['name']; ?></td>
      <?php if($s->season['classes'] == 1): ?>
        <td><?php echo $classes[$dq['class']]['class_name'] ?></td>
      <?php endif; ?>
      <td><?php echo $dq['car']; ?></td>
      <?php for($i = 0; $i < $s->season['rounds']*$s->season['races_per_round']; $i++): ?>
        <td><?php echo $dq['rounds'][$i]['pts']; ?></td>
      <?php endfor; ?>
      <td style="background-color:<?php echo $dq['inc_color']; ?>"><?php echo $dq['total_inc']; ?></td>
      <td><?php echo $dq['total_pts']; ?></td>
    </tr>
  <?php endforeach; ?>
</tbody>
</table>
</div>
