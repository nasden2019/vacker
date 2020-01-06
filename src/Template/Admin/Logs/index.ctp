<div class="content-wrapper">
	<div class="col-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">
					<?php echo $logType ? $this->Log->typeLabel($logType) : ''; ?> Logs
				</h4>
				<p class="card-description">
					Listado de logs del sistema
				</p>
					
				<div class="btn-group" role="group" aria-label="Tipos disponibles">
					<?= $this->Html->link(
						'Todos', 
						[
							'controller' => 'Logs', 
							'action' => 'index'
						], [
							'class' => 'btn btn-outline-secondary'
						]
					) ?>
					<?php foreach ($types as $type) {
						$this->Html->link(
							$this->Log->typeLabel($type), 
							[
								'controller' => 'Logs', 
								'action' => 'index', 
								'?' => ['type' => $type]
							], [
								'escape' => false,
								'class' => 'btn btn-outline-secondary'
							]
						);
						
					} ?>

					<?= $this->Form->postLink(
						__('Remove {0}', __('Duplicates')
					), [
						'action' => 'removeDuplicates'
					], [
						'class' => 'btn btn-warning'
					]); ?>

					<?php if ($logType) : ?>
						<?= $this->Form->postLink(
							__('Reset {0}', 
							'"' . $logType . '" ' . __('Logs')
							), [
								'action' => 'reset', 
								'?' => ['type' => $logType]
							], [
								'confirm' => 'Seguro?',
								'class' => 'btn btn-danger'
							]
						) ?></li>
					<?php endif; ?>
					
					<?= $this->Form->postLink(
						__('Reset {0}', 
						__('Logs')
						), [
							'action' => 'reset'
						], [
							'confirm' => 'Seguro?', 
							'class' => 'btn btn-danger'
						]) ?>
				</div>
				
				<?= $this->element('DatabaseLog.admin_filter'); ?>

				<table class="table table-hover">
					<thead>
						<tr>
							<th><?= $this->Paginator->sort('created', 'Fecha'); ?></th>
							<th><?= $this->Paginator->sort('type', 'Tipo'); ?></th>
							<th><?= $this->Paginator->sort('message', 'Mensaje'); ?></th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>

						<?php foreach ($logs as $log):
							$message = $log['message'];
							$pos = strpos($message, 'Stack Trace:');
							if ($pos) {
								$message = trim(substr($message, 0, $pos));
							}
							$pos = strpos($message, 'Trace:');
							if ($pos) {
								$message = trim(substr($message, 0, $pos));
							}
							?>
							<tr>
								<td><?php echo $this->Time->nice($log['created']); ?>&nbsp;</td>
								<td><?php echo $this->Log->typeLabel($log['type']); ?>
									<?php if ($log['count'] > 1) { ?>
										<div class="log-count">
											<small>(<?php echo h($log['count']); ?>x)</small>
										</div>
									<?php } ?>
								</td>
								<td><?php echo nl2br(h($message)); ?>&nbsp;</td>
								<td class="actions">
									<?php echo $this->Html->link(__('Details'), ['action' => 'view', $log['id'], '?' => $this->request->query]); ?>
									<?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $log['id']], ['confirm' => __('Seguro que queres eliminar este log # {0}?', $log['id'])]); ?>
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

