<template>
    <div class="container">
        <h2>Ventas</h2>
        <div class="btn-group pull-right">
            <button class="btn btn-primary" @click="">Agregar</button>
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
                    <td>{{ sale.talla }}</td>
                    <td>
                        <i class="fa fa-trash" @click="remove(sale)"></i>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                data: new FormData(),
                categories: [],
                errors: {},
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
                axios.delete(url + 'api/product/' + product.id)
                    .then(response => {
                        this.getProducts();
                    }).catch(errors => {
                        if(typeof errors.response.data === 'object'){
                            this.errors = _.flatten(_.toArray(errors.response.data))
                        }else{
                            this.errors = ['Algo salió mal'];
                        }
                    })
            }
        },
        mounted() {
            this.getSales();
        }
    }
</script>
