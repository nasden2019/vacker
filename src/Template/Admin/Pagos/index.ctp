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
									<input type="text" name="fecha_desde" class="form-control fechas" placeholder="Fecha Desde" value="<?php if(!empty($this->request->query['fecha_desde'])) echo $this->request->query['fecha_desde']; ?>">
								</div>
							</div>
							<div class="col-xs-12 col-md-4">
								<div class="form-group col-xs-12">
									<input type="text" name="fecha_hasta" class="form-control fechas" placeholder="Fecha Hasta" value="<?php if(!empty($this->request->query['fecha_hasta'])) echo $this->request->query['fecha_hasta']; ?>">
								</div>
							</div>
							<div class="col-xs-12 col-md-4">
								<div class="form-group col-xs-12">
									<input type="text" name="q" class="form-control" placeholder="Nombre o Email" value="<?php if(!empty($this->request->query['q'])) echo $this->request->query['q']; ?>">
								</div>
							</div>
							<div class="col-xs-12 col-md-4">
								<div class="form-group col-xs-12">
									<?= $this->Form->input('origen', ['class' => 'form-control select2', 'options' => $mediosPago, 'empty' => 'Seleccione Origen', 'label' => false,'style' => 'width:100%;']); ?>
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
		              	<h2 class="page-header" style="margin-top: 0px;"><i class='fa fa-balance-scale'></i> Listado de Pagos</h2>
		              	<address>
		                <?= (!empty($this->request->query['fecha_desde']))? 'Fecha desde: '.$this->request->query['fecha_desde'].'<br>' : ''; ?> 
		                <?= (!empty($this->request->query['fecha_hasta']))? 'Fecha hasta: '.$this->request->query['fecha_hasta'].'<br>' : ''; ?>
		                <?= (!empty($this->request->query['q']))? 'Nombre o Email: '.$this->request->query['q'].'<br>' : ''; ?> 
		                <?= (!empty($this->request->query['origen']))? 'Origen: '.$mediosPago[$this->request->query['origen']].'<br>' : ''; ?>
		              	</address>
		            </div>
		        </div>
			</div>

			<div class="card-body">
				<div class="box-body table-responsive">
				<table class="table">
					<thead>
						<tr class="active">
							<th></th>
							<th>Usuarios</th>
							<th><?php echo $this->Paginator->sort('created', 'Fecha y Hora'); ?></th>
							<th><?php echo $this->Paginator->sort('monto', 'Monto'); ?></th>
							<th><?php echo $this->Paginator->sort('status', 'Estado'); ?></th>
							<th><?php echo $this->Paginator->sort('origen', 'Origen'); ?></th>
							<th class="text-center ocultar_imprimir">Acciones</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($pagos as $c): ?>
							<tr>
								<td></td>
								<td><?= h($c->usuario->apellido) ?>, <?= h($c->usuario->nombre) ?> ( <?= h($c->usuario->email) ?> )</td>
								<td><?= h($c->created->format('d/m/Y H:i')) ?></td>
								<td> $ <?= h($c->monto) ?></td>
								<td><?= h($c->status) ?></td>
								<td><?= h($c->origen) ?></td>
								<!-- <td><?php if(strlen($c->datos) > 200) echo substr($c->datos, 0,150)."..."; else echo $c->datos; ?></td> -->
								<td class="text-center ocultar_imprimir">
									<?= $this->Form->postLink(__(null), ['action' => 'eliminar', $c->id], ['class' => 'mdi mdi-close-circle-outline', 'confirm' => __('¿Estas seguro de eliminar este pago?')]) ?>
								</td>
								<td></td>
							</tr>
						<?php endforeach; ?>

					</tbody>
				</table>
				</div>
			</div>
		<?= $this->element('Admin/paginador') ?>
		</div>
	</div>
</div>
<script>
$(function () {
  $(".select2").select2();
  $('.fechas').datetimepicker({
    format: "DD-MM-YYYY",
    locale: 'es',
    // defaultDate: new Date(),
    defaultDate: false,
    widgetPositioning: {
      horizontal: 'left',
      vertical: 'bottom'
    }
  });
  $('.años').datetimepicker({
    format: "YYYY",
    widgetPositioning: {
      horizontal: 'left',
      vertical: 'bottom'
    }
  });
  $('.horas').datetimepicker({
    format: "HH:mm",
    widgetPositioning: {
      horizontal: 'left',
      vertical: 'bottom'
    }
  });

  $('.datetimepicker').datetimepicker({
   format: "DD-MM-YYYY H:mm",
   locale: 'es',
   // defaultDate: new Date(),
   defaultDate: false,
   widgetPositioning: {
     horizontal: 'left',
     vertical: 'bottom'
   }
 });


  /* Resalta de Rojo un error en input */
  if($(".input").hasClass("error")){
    $(".error").parent().parent().addClass('has-error');
    $(".error-message").css('color', '#dd4b39');
  }

  $(".limpiar_filtro").on("click", function (e) {
      e.preventDefault();
     $("#formulario_filtro")[0].reset();
     $("#formulario_filtro").closest('form').find("input[type=text], textarea").val("");
     $(".select2").select2().val('').trigger("change");
     $(".fechas").val('');
     $("#formulario_filtro").submit();
  });

});
</script>