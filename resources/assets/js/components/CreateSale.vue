<template>
	<div class="container">
		<h2>Crear venta</h2>
		<label>Codigo de roducto</label>
		<input class="form-control" type="text" v-model="codigo"></input>
		<button @click='searchProducts'>Agregar</button>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Codigo</th>
					<th>Producto</th>
					<th>Descripcion</th>
					<th>Cantidad</th>
					<th>Monto</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(product, index) in sale.products">
					<td>{{ product.codigo }}</td>
					<td>{{ product.nombre }}</td>
					<td>{{ product.descripcion }}</td>
					<td>{{ product.cantidad }}</td>
					<td>{{ product.precio | currency('$') }}</td>
					<td>
						{{ product.total | currency('$') }}
						<i class="fa fa-trash btn-hide" @click="deleteArticle(index, product)"></i>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th>Subtotal</th>
					<th>{{ sale.subtotal | currency('$') }}</th>
				</tr>
				<tr>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th>IVA</th>
					<th>{{ sale.iva | currency('$') }}</th>
				</tr>
				<tr>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th>Total</th>
					<th>{{ sale.total | currency('$') }}</th>
				</tr>
			</tfoot>
		</table>
		<button class="btn btn-success pull-right" @click="storeSale">Generar</button>
	</div>
</template>

<script>
	export default {
		data(){
			return {
				codigo: '',
				sale: {
					products: [],
					iva: 0,
					subtotal: 0,
					total: 0,
				},
			}
		},
		methods: {
			calculateTotal(){
				this.sale.subtotal = 0;
				this.sale.iva = 0;
				this.sale.total = 0;
				for(var i = 0; i < this.sale.products.length; i++){
					this.sale.subtotal += this.sale.products[i].total;
				}
				this.sale.iva = this.sale.subtotal * .16;
				this.sale.total = this.sale.subtotal * 1.16;
			},
			deleteArticle(index, product){
				this.sale.products[index].cantidad--;
				this.sale.products[index].total = this.sale.products[index].cantidad * this.sale.products[index].precio;
				if(this.sale.products[index].cantidad <= 0){
					this.sale.products.splice(index, 1);
				}
				this.calculateTotal();
			},
			searchProducts(){
				axios.get(url + 'api/search/product?s=' + this.codigo)
					.then(response => {
						if(response.data != ''){
							var found = 'empty';
							for(var i = 0; i < this.sale.products.length; i++){
								if(this.sale.products[i].id == response.data.id){
									found = i;
									i = this.sale.products.length;
								}
							}

							if(found == 'empty'){
								response.data.cantidad = 1;
								response.data.total = response.data.cantidad * response.data.precio;
								this.sale.products.push(response.data);
							}else{
								this.sale.products[found].cantidad++;
								this.sale.products[found].total = this.sale.products[found].cantidad * this.sale.products[found].precio;
							}
							this.codigo = '';
							this.calculateTotal();
						}else{
							alert('No se encontro el producto');
						}
					}).catch(error => {
						alert('No se encontro el producto');
					});
			},
			storeSale(){
				axios.post(url + 'api/sale', this.sale)
					.then(response => {
						this.sale = {
							products: [],
							iva: 0,
							subtotal: 0,
							total: 0,
						}
					}).catch(error => {

					});
			},
		},
		mounted() {
		},
	}
</script>
