<div class="content-wrapper">
	<div class="col-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><?= $this->request['controller'] ?></h4>
				<p class="card-description">
					Listado de usuarios del sistema
				</p>

				<table class="table table-hover">
					<thead>
						<tr>
							<th></th>
							<th><?= $this->Paginator->sort('nombre', 'Nombre Apellido'); ?></th>
							<th><?= $this->Paginator->sort('rol', 'Rol'); ?></th>
							<th><?= $this->Paginator->sort('created', 'Registrado el'); ?></th>
							<th class="text-center">Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($usuarios as $c): ?>
						<tr>
							<td><a href="https://mail.google.com/mail/?view=cm&fs=1&tf=1&to=<?=$c->email?>"><i class="mdi mdi-email"></i></a> <i class="mdi mdi-drag-vertical"></i>
							<a href="tel:<?=$c->telefono?>"><i class="mdi mdi-phone"></i></a></td>
							<td><?= h($c->nombre) ?> <?= h($c->apellido) ?></td>
							<td><?= h($c->rol) ?></td>
							<td><?= h($c->created) ?></td>
							<td class="text-center">
								<?= $this->Html->link(
									'<i class="mdi mdi-pencil"></i>',
									['action' => 'editar', $c->id],
									['class' => 'btn btn-sm btn-primary', 'escape' => false]) 
								?>

								<?= $this->Form->postLink(
									'<i class="mdi mdi-delete"></i>',
									['action' => 'eliminar', $c->id],
									['confirm' => __('¿Seguro que desea eliminar el usuario con email {0}?', $c->email), 'class' => 'btn btn-sm btn-danger', 'escape' => false]) 
								?>
								
                    			<?php if($userLogin['id'] == 1):?>
									<?= $this->Html->link(
										'<i class="mdi mdi-login"></i>', 
										['action' => 'loginWith', $c->id], 
										['class' => 'btn btn-sm btn-dark editar', 'data-id' => $c->id, 'escape' => false, 'confirm' => __('Estás seguro de loguearte como {0}?', $c->nombre), 'target' => '_blank'])
									?>
								<?php endif;?>
							</td>
						</tr>
	
						<?php endforeach; ?>					
					</tbody>
				</table>
			</div>
			<?= $this->element('Admin/paginador') ?>
		</div>
	</div>
</div>