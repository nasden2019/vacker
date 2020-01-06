<div class="content-wrapper">
	<div class="col-12 grid-margin stretch-card">
		<div class="card">
			<!-- Filtro -->
			<div class="card-body ocultar_imprimir">
				<?= $this->Form->create(null, ['id' => 'formulario_filtro', 'type' => 'GET']); ?>
					<div class="row">
						<div class="col-md-12 row">
							<div class="col-xs-12 col-md-4">
								<div class="form-group col-xs-12">
									<input type="text" name="search" class="form-control" placeholder="Nombre o Descripcion" value="<?php if(!empty($this->request->query['search'])) echo $this->request->query['search']; ?>">
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-md-4">
							<button class="btn btn-primary pull-right"><i class="mdi mdi-magnify"></i> Buscar</button>
							<button class="btn btn-default limpiar_filtro"><i class="mdi mdi-filter-remove"></i> Limpiar</button>
						</div>
					</div>
				<?= $this->Form->end(); ?>
			</div>
			<!-- ./Filtro -->

			<div class="card-body">
				<div class="row">
		            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
		              	<h2 class="page-header" style="margin-top: 0px;"><i class='fa fa-balance-scale'></i> Listado de Productos</h2>
		              	<address>
		                <?= (!empty($this->request->query['search']))? 'Nombre o Descripcion: '.$this->request->query['search'].'<br>' : ''; ?>
		              	</address>
		            </div>
		        </div>
			</div>

			<div class="card-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th><?= $this->Paginator->sort('id', 'Id'); ?></th>
							<th><?= $this->Paginator->sort('name', 'Nombre del producto'); ?></th>
							<th><?= $this->Paginator->sort('price', 'Precio'); ?></th>
							<th class="text-center">Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($products as $p): ?>
							<tr>
								<td><?= h($p->id) ?></td>
								<td><?= h($p->name) ?></td>
								<td><?= h($p->price) ?></td>
								<td class="text-center">
									<?= $this->Html->link(
										'<i class="mdi mdi-pencil"></i>',
										['action' => 'editar', $p->id],
										['class' => 'btn btn-sm btn-primary', 'escape' => false]) 
									?>

									<?= $this->Form->postLink(
										'<i class="mdi mdi-delete"></i>',
										['action' => 'eliminar', $p->id],
										['confirm' => __('¿Seguro que desea eliminar el producto con id {0}?', $p->id), 'class' => 'btn btn-sm btn-danger', 'escape' => false]) 
									?>
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