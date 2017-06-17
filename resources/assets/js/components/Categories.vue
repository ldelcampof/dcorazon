<template>
    <div class="container">
        <h2>Categorias</h2>
        <div class="btn-group pull-right">
            <button class="btn btn-primary" @click="openCreate">Agregar</button>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Categoria</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="category in categories">
                    <td>{{ category.id }}</td>
                    <td>{{ category.name }}</td>
                    <td>
                        <i class="fa fa-pencil" @click="openEdit(category)"></i>
                        <i class="fa fa-trash" @click="remove(category)"></i>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="modal fade" tabindex="-1" role="dialog" id="addCategory">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Alta de categoria</h4>
                    </div>
                    <div class="modal-body">
                        <div class="warn" v-if="errors.length > 0">
                            <li v-for="error in errors">{{ error }}</li>
                        </div>
                        <div class="form-group">
                            <label>Nombre</label>
                            <input class="form-control" v-model="category.name" type="text"></input>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" >Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="storeCategory">Guardar</button>
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
                categories: [],
                category: {
                    name: '',
                }
            }
        },
        methods: {
            getCategories(){
                axios.get(url + 'api/category')
                    .then(response => {
                        this.categories = response.data.data;
                    }).catch(error => {
                        this.errors = error.response.data;
                    })
            },
            openCreate(){
                $('#addCategory').modal('show');
            },
            storeCategory(){
                axios.post(url + 'api/category', this.category)
                    .then(response => {
                        this.category = {
                            name: '',
                        };
                        $('.modal').modal('hide');
                        this.getCategories();
                    }).catch(errors => {
                        if(typeof errors.response.data === 'object'){
                            this.errors = _.flatten(_.toArray(errors.response.data))
                        }else{
                            this.errors = ['Algo salió mal'];
                        }
                    })
            },
            remove(category){
                axios.delete(url + 'api/category/' + category.id)
                    .then(response => {
                        this.getProducts();
                    }).catch(errors => {
                        if(typeof errors.response.data === 'object'){
                            this.errors = _.flatten(_.toArray(errors.response.data))
                        }else{
                            this.errors = ['Algo salió mal'];
                        }
                    });
            }
        },
        mounted() {
            this.getCategories();
        }
    }
</script>
