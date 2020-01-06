<div class="content-wrapper">
	<div class="col-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Lista de páginas</h4>
				<table class="table table-hover">
					<thead>
						<tr>
							<th></th>
							<th><?php echo $this->Paginator->sort('nombre', 'Nombre'); ?></th>
							<th><?php echo $this->Paginator->sort('slug', 'Slug'); ?></th>
							<th><?php echo $this->Paginator->sort('imagen', 'Imágen'); ?></th>
							<th class="text-center">Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($paginas as $c): ?>
						<tr>
							<td></td>
							<td><?= h($c->nombre) ?></td>
							<td><?= h($c->slug) ?></td>
							<td><img src="<?php echo HOST."img/paginas/".$c->imagen ?>" height="25px" ></td>
							<td class="text-center"><?= $this->Html->link(null, ['action' => 'editar', $c->id], ['class' => 'mdi mdi-pencil']) ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<?= $this->element('Admin/paginador') ?>
		</div>
	</div>
</div>