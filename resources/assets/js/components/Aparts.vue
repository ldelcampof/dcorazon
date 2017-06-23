<template>
	<div class="container">
		<h2>Apartados</h2>
		<div class="btn-group pull-right">
			<button class="btn btn-primary" @click="sendApart">Agregar</button>
		</div>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Cliente</th>
					<th>Saldo</th>
					<th>Fecha</th>
					<th>Subtotal</th>
					<th>IVA</th>
					<th>Total</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="apart in aparts">
					<td>{{ apart.id }}</td>
					<td>{{ apart.customer.name }}</td>
					<td>{{ apart.rest | currency('$') }}</td>
					<td>{{ apart.created_at }}</td>
					<td>{{ apart.sale.subtotal | currency("$") }}</td>
					<td>{{ apart.sale.subtotal * .16 | currency("$") }}</td>
					<td>{{ apart.sale.subtotal * 1.16 | currency("$") }}</td>
					<td>
						<i class="fa fa-money" title="Agregar abono" @click="openPayment(apart)"></i>
						<i class="fa fa-search" title="Ver productos" @click="view(apart)"></i>
						<i class="fa fa-trash" title="Eliminar apartado" @click="remove(apart)"></i>
					</td>
				</tr>
			</tbody>
		</table>
	    <div class="modal fade" tabindex="-1" role="dialog" id="view-sale">
	        <div class="modal-dialog" role="document">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                    <h4 class="modal-title">Productos vendidos</h4>
	                </div>
	                <div class="modal-body">
	                    <div class="form-group">
	                        <table class="table">
	                        	<thead>
	                        		<th>Partida</th>
	                        		<th>Articulo</th>
	                        		<th>Precio</th>
	                        		<th>Cantidad</th>
	                        		<th>Total</th>
	                        	</thead>
	                        	<tbody>
	                        		<tr v-for="(article, index) in apart.sale.articles">
	                        			<td>{{ index+1 }}</td>
	                        			<td>{{ article.product.nombre }}</td>
	                        			<td>{{ article.price | currency('$') }}</td>
	                        			<td>{{ article.quantity }}</td>
	                        			<td>{{ article.quantity * article.price | currency('$') }}</td>
	                        		</tr>
	                        	</tbody>
	                        </table>
	                        </ul>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="modal fade" tabindex="-1" role="dialog" id="add-payment">
	        <div class="modal-dialog" role="document">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                    <h4 class="modal-title">Agregar abono</h4>
	                </div>
	                <div class="modal-body">
	                	<label>Cantidad</label>
	                	<input class="form-control" type='number' step="any" v-model="payment.ammount"></input>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
	                    <button type="button" class="btn btn-success" @click="storePayment">Guardar</button>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				apart: {
					sale: {},
				},
				aparts: [],
				categories: [],
				errors: {},
				payment: {
					ammount: 0,
					sale_id: '',
				}
			}
		},
		methods: {
			getSales(){
				axios.get(url + 'api/apart')
					.then(response => {
						this.aparts = response.data.data;
					}).catch(error => {
						this.errors = error.response.data;
					})
			},
			openPayment(apart){
				this.apart = apart;
				this.payment.sale_id = apart.id;
				$('#add-payment').modal('show');
			},
			remove(apart){
				if(confirm("Realmente deseas eliminar este apartado?")){
					axios.delete(url + 'api/apart/' + apart.id)
						.then(response => {
							this.getSales();
						}).catch(errors => {
							if(typeof errors.response.data === 'object'){
								this.errors = _.flatten(_.toArray(errors.response.data));
							}else{
								this.errors = ['Algo salió mal'];
							}
						});
				}
			},
			sendApart(){
				window.location.href = url + 'create-apart';
			},
			storePayment(){
				if(this.apart.rest >= this.payment.ammount){
					axios.post(url + 'api/payment', this.payment)
						.then(response => {
							this.payment = {
								sale_id: '',
								ammount: 0,
							}
							$('.modal').modal('hide');
							this.getSales();
						}).catch(error => {
							this.errors = ['Algo salio mal!'];
						})
				}else{
					alert('El monto excede el restante del apartado');
				}
			},
			view(apart){
				this.apart = apart;
				$('#view-sale').modal('show');
			},
		},
		mounted() {
			this.getSales();
		}
	}
</script>
