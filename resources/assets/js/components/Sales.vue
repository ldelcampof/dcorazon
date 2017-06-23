<template>
	<div class="container">
		<h2>Ventas</h2>
		<div class="btn-group pull-right">
			<button class="btn btn-primary" @click="sendSale">Agregar</button>
		</div>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Fecha</th>
					<th>Subtotal</th>
					<th>IVA</th>
					<th>Total</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="sale in sales">
					<td>{{ sale.id }}</td>
					<td>{{ sale.created_at }}</td>
					<td>{{ sale.subtotal | currency("$") }}</td>
					<td>{{ sale.subtotal * .16 | currency("$") }}</td>
					<td>{{ sale.subtotal * 1.16 | currency("$") }}</td>
					<td>
						<i class="fa fa-search" @click="view(sale)"></i>
						<i class="fa fa-trash" @click="remove(sale)"></i>
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
	                        		<tr v-for="(article, index) in sale.articles">
	                        			<td>{{ index+1 }}</td>
	                        			<td>{{ article.product.nombre }}</td>
	                        			<td>{{ article.price | currency('$') }}</td>
	                        			<td>{{ article.quantity }}</td>
	                        			<td>{{ article.quantity*article.price | currency('$') }}</td>
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
	</div>
</template>

<script>
	export default {
		data() {
			return {
				data: new FormData(),
				categories: [],
				errors: {},
				sale: {},
				sales: [],
			}
		},
		methods: {
			getSales(){
				axios.get(url + 'api/sale')
					.then(response => {
						this.sales = response.data.data;
					}).catch(error => {
						this.errors = error.response.data;
					})
			},
			remove(product){
				if(alert("Realmente deseas eliminar esta venta?")){
					axios.delete(url + 'api/sale/' + product.id)
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
			sendSale(){
				window.location.href = url + 'create-sale';
			},
			view(sale){
				this.sale = sale;
				$('#view-sale').modal('show');
			},
		},
		mounted() {
			this.getSales();
		}
	}
</script>
