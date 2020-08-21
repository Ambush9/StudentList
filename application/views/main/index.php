<h2>Список абитуриентов</h2>

<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Scores</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($studentList as $student):?>
    <tr>
      <th scope="row"><?php echo $student['id'];?></th>
      <td><?php echo $student['login'];?></td>
      <td><?php echo $student['scores'];?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
