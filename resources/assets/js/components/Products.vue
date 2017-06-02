<template>
    <div class="container">
        <h2>Productos</h2>
        <div class="btn-group">
            <button class="btn btn-primary" @click="openCreate">Agregar</button>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Categoria</th>
                    <th>Talla</th>
                    <th>Foto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products">
                    <td>{{ product.id }}</td>
                    <td>{{ product.codigo }}</td>
                    <td>{{ product.nombre }}</td>
                    <td>{{ product.descripcion }}</td>
                    <td>{{ product.categoria }}</td>
                    <td>{{ product.talla }}</td>
                    <td><img :src="product.foto"></td>
                    <td>
                        <i class="glyphicon glyphicon-pencil" @click="openEdit(product)"></i>
                        <i class="glyphicon glyphicon-trash" @click="remove(product)"></i>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="modal fade" tabindex="-1" role="dialog" id="addProduct">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Alta de producto</h4>
                    </div>
                    <div class="modal-body">
                        <div class="warn" v-if="errors.length > 0">
                            <li v-for="error in errors">{{ error }}</li>
                        </div>
                        <div class="form-group">
                            <label>Codigo</label>
                            <input class="form-control" v-model="product.codigo" type="text"></input>
                            <label>Nombre</label>
                            <input class="form-control" v-model="product.nombre" type="text"></input>
                            <label>Descripcion</label>
                            <input class="form-control" v-model="product.descripcion" type="text"></input>
                            <label>Categoria</label>
                            <input class="form-control" v-model="product.categoria" type="text"></input>
                            <label>Talla</label>
                            <input class="form-control" v-model="product.talla" type="text"></input>
                            <label>Precio</label>
                            <input class="form-control" v-model="product.precio" type="number" step="any"></input>
                            <label>Fotografia</label>
                            <input class="form-control" type="file" @change="addFile($event, 'foto')"></input>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" >Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="storeProduct">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="editProduct">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Edicion de producto</h4>
                    </div>
                    <div class="modal-body">
                        <div class="warn" v-if="errors.length > 0">
                            <li v-for="error in errors">{{ error }}</li>
                        </div>
                        <div class="form-group">
                            <label>Codigo</label>
                            <input class="form-control" v-model="editProduct.codigo" type="text"></input>
                            <label>Nombre</label>
                            <input class="form-control" v-model="editProduct.nombre" type="text"></input>
                            <label>Descripcion</label>
                            <input class="form-control" v-model="editProduct.descripcion" type="text"></input>
                            <label>Categoria</label>
                            <input class="form-control" v-model="editProduct.categoria" type="text"></input>
                            <label>Talla</label>
                            <input class="form-control" v-model="editProduct.talla" type="text"></input>
                            <label>Precio</label>
                            <input class="form-control" v-model="editProduct.precio" type="number" step="any"></input>
                            <label>Fotografia</label>
                            <input class="form-control" type="file" @change="addFile($event, 'foto')"></input>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" >Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="updateProduct">Guardar</button>
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
                errors: {},
                editProduct: {
                    nombre: '',
                    descripcion: '',
                    categoria: '',
                    talla: '',
                    foto: '',
                },
                product: {
                    nombre: '',
                    descripcion: '',
                    categoria: '',
                    talla: '',
                    foto: '',
                },
                products: [],
            }
        },
        methods: {
            addFile(e, nombre){
                this.data.append('file' + nombre, e.target.files[0])
            },
            getProducts(){
                axios.get(url + 'api/product')
                    .then(response => {
                        this.products = response.data.data;
                    }).catch(error => {
                        this.errors = error.response.data;
                    })
            },
            openCreate(){
                $('#addProduct').modal('show');
            },
            openEdit(product){
                this.editProduct = JSON.parse(JSON.stringify(product));
                $('#editProduct').modal('show');
            },
            storeProduct(){
                this.data.append('product', JSON.stringify(this.product));
                axios.post(url + 'api/product', this.data)
                    .then(response => {
                        this.product = {
                            nombre: '',
                            descripcion: '',
                            categoria: '',
                            talla: '',
                            foto: '',
                        };
                        this.data = new FormData();
                        $('.modal').modal('hide');
                        this.getProducts();
                    }).catch(errors => {
                        if(typeof errors.response.data === 'object'){
                            this.errors = _.flatten(_.toArray(errors.response.data))
                        }else{
                            this.errors = ['Algo salió mal'];
                        }
                    })
            },
            updateProduct(){
                this.data.append('product', JSON.stringify(this.editProduct));
                axios.post(url + 'api/update/product/' + this.editProduct.id, this.data)
                    .then(response => {
                        this.editProduct = {
                            nombre: '',
                            descripcion: '',
                            categoria: '',
                            talla: '',
                            foto: '',
                        };
                        this.data = new FormData();
                        $('.modal').modal('hide');
                        this.getProducts();
                    }).catch(errors => {
                        if(typeof errors.response.data === 'object'){
                            this.errors = _.flatten(_.toArray(errors.response.data))
                        }else{
                            this.errors = ['Algo salió mal'];
                        }
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
            this.getProducts();
        }
    }
</script>
