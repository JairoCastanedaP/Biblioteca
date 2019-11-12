<template>
    <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Libros
                        <button type="button" @click="abrirModal('libro','registrar')" class="btn btn-secondary" >
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">

                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="titulo">Titulo</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarLibro(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarLibro(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Código</th>
                                    <th>Titulo</th>
                                    <th>Categoría</th>
                                    <th>Editorial</th>
                                    <th>valor</th>
                                    <th>Stock</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>       
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="libro in arrayLibro" :key="libro.id">
                                    <td>
                                        <button type="button" @click="abrirModal('libro','actualizar',libro)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="libro.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarLibro(libro.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarLibro(libro.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="libro.codigo"></td>
                                    <td v-text="libro.titulo"></td>
                                    <td v-text="libro.nombre_categoria"></td>
                                    <td v-text="libro.editorial"></td>
                                    <td v-text="libro.valor"></td>
                                    <td v-text="libro.stock"></td>
                                    <td v-text="libro.descripcion"></td>

                                    <td>
                                        <div v-if="libro.condicion">
                                            <span class="badge badge-success">Activado</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page>1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item active" v-for="page in pagesNumber" :key="page" :class="[page== isActived ? 'active':'' ]">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar':modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Categoría</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idcategoria">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre">
                                                </option>
                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Código</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="codigo" class="form-control" placeholder="Código del documento">
                                        <barcode :value="codigo" :options="{format:'EAN-13'}">
                                            Generando código de barras
                                        </barcode>
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Titulo</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="titulo" class="form-control" placeholder="Titulo del documento">
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripcion</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="descripcion" class="form-control" placeholder="Descripción del documento">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Valor</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="valor" class="form-control" placeholder="">
                                    </div>
                                </div> 
                                  <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Editorial</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="editorial" class="form-control" placeholder="Editorial">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Stock</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="stock" class="form-control" placeholder="">
                                    </div>
                                </div>                                 
                                <div v-show="errorLibro" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjLibro" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarLibro()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarLibro()">Actualizar</button>
                       
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->     
        </main>
</template>

<script>
import VueBarcode from 'vue-barcode';
    export default {
        data(){
            return{
                libro_id:0,
                idcategoria:0,
                nombre_categoria: '',
                codigo: '',
                //nombre:'',
                titulo:'',
                valor:0,
                stock:0,
                editorial:'',
                descripcion:'',
                arrayLibro:[],
                modal:0,
                tituloModal:'',
                tipoAccion: 0,
                errorLibro:0,
                errorMostrarMsjLibro: [],
                pagination: {
                    'total': 0,
                    'current_page':0,
                    'per_page':0,
                    'last_page':0,
                    'from':0,
                    'to':0
                },
                offset:3,
                criterio:'titulo',
                buscar :'',
                arrayCategoria:[]
            }
        },
        components: {
            'barcode': VueBarcode
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            // calcúla los elementos de la paginación
            pagesNumber : function(){
                if(!this.pagination.to){
                    return [];
                }
                var from = this.pagination.current_page-this.offset;
                if(from <1){
                    from =1;
                }
                var to =from +(this.offset*2);
                if(to>=this.pagination.last_page){
                    to =this.pagination.last_page;
                } 
                var pagesArray=[];
                while(from <=to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods:{
            listarLibro(page,buscar,criterio){
                let me=this;
                var url='/libro?page='+page +'&buscar='+buscar+'&criterio='+criterio;
                //const axios = require('axios');
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayLibro= respuesta.libros.data;
                    me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(function () {
                });
            },
            selectCategoria(){
                let me=this;
                var url='/categoria/selectCategoria';
                //const axios = require('axios');
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayCategoria= respuesta.categorias;
                    
                  // console.log(response);

                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(function () {
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me =this;
                //actualiza la pagina actual
                me.pagination.current_page= page;
                //envía la petición para visualizar la data de esa pagina
                me.listarLibro(page,buscar,criterio);

            },
            registrarLibro(){
                if(this.validarLibro()){
                    return ;
                }
                let me=this;

                axios.post('/libro/registrar',{
                    'idcategoria' :this.idcategoria,
                    'titulo'      :this.titulo,
                    'descripcion' :this.descripcion,
                    'valor'       :this.valor,
                    'editorial'   :this.editorial,
                    'stock'       :this.stock,
                    'codigo'       :this.codigo
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarLibro(1,'','titulo');

                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            actualizarLibro(){
                 if(this.validarLibro()){
                    return ;
                }
                let me=this;

                axios.put('/libro/actualizar',{
                    'idcategoria' :this.idcategoria,
                    'titulo'      :this.titulo,
                    'descripcion' :this.descripcion,
                    'valor'       :this.valor,
                    'editorial'   :this.editorial,
                    'stock'       :this.stock,
                    'codigo'       :this.codigo,
                    'id' :this.libro_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarLibro(1,'','titulo');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            desactivarLibro(id){
                    const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })
                    swalWithBootstrapButtons.fire({
                    title: 'Estás seguro de desactivar este documento?',
                   // text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si , desactivar!',
                    cancelButtonText: 'No, cancelar!',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                        let me=this;

                        axios.put('/libro/desactivar',{
                            
                            'id': id
                        }).then(function (response) {
                            me.listarLibro(1,'','titulo');

                            swalWithBootstrapButtons.fire(
                            'Desactivado!',
                            'El documento ha sido desactivado con éxito',
                            'succes'
                            )
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                        'Cancelado',
                        'El documento no ha sido desactivado',
                        'error'
                        )
                    }
                    })
            },
            activarLibro(id){
                    const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })
                    swalWithBootstrapButtons.fire({
                    title: 'Estás seguro de activar este documento ?',
                   // text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si , activar!',
                    cancelButtonText: 'No, cancelar!',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                        let me=this;

                        axios.put('/libro/activar',{
                            
                            'id': id
                        }).then(function (response) {
                            me.listarLibro(1,'','titulo');

                            swalWithBootstrapButtons.fire(
                            'Activado!',
                            'El documento ha sido activada con éxito',
                            'succes'
                            )
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                        'Cancelado',
                        'El documento no ha sido activado',
                        'error'
                        )
                    }
                    })
            },
            validarLibro(){
                this.errorLibro=0;
                this.errorMostrarMsjLibro=[];

                if(this.idcategoria==0)this.errorMostrarMsjLibro.push("Seleccione una categoría");
                if(!this.stock)this.errorMostrarMsjLibro.push("El stock del documento debe ser un número y no puede estar vacío");
                if(!this.codigo)this.errorMostrarMsjLibro.push("El código del documento no puede estar vacío");
                if(!this.titulo)this.errorMostrarMsjLibro.push("El titulo del documento no puede estar vacío");
               
               if(this.errorMostrarMsjLibro.length)this.errorLibro=1;
                return this.errorLibro;
           },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.titulo='';
                this.idcategoria=''
                this.descripcion='';
                this.nombre_categoria='';
                this.editorial='';
                this.stock=0;
                this.codigo='';
                this.valor=0;
                this.errorLibro=0;
            },
            abrirModal(modelo,accion,data =[]){
                switch(modelo){
                    case "libro":
                        {
                            switch(accion){
                                case 'registrar':
                                {
                                    this.modal=1;
                                    this.tituloModal='Registrar documento';
                                    this.idcategoria=0;
                                    this.titulo='';
                                    this.editorial='';
                                    this.stock=0;
                                    this.codigo='';
                                    this.valor=0;
                                    this.descripcion='';
                                    this.tipoAccion=1;
                                    this.nombre_categoria='';
                                    break;
                                } 
                                case 'actualizar':{
                                   // console.log(data);
                                   this.modal=1;
                                   this.tituloModal='Actualizar documento';
                                   this.tipoAccion=2;
                                   
                                   this.libro_id=data['id'];
                                   this.idcategoria=data['idcategoria'];
                                   this.codigo=data['codigo'];
                                   this.titulo=data['titulo'];
                                   this.valor=data['valor'];
                                   this.editorial=data['editorial'];
                                   this.stock=data['stock'];
                                   this.descripcion=data['descripcion'];
                                   
                                   break;
                                }

                             }
                        }
                 }
                 this.selectCategoria();
            }
   },
        mounted() {
            this.listarLibro(1,this.buscar,this.criterio);
        }
    }
</script>
<style>
.modal-content{
    width: 100% !important;
    position: absolute !important;
}
.mostrar{
    display: list-item !important;
    opacity: 1 !important;
    position: absolute !important;
    background-color: #3c29297a !important;
}
.div-error{
    display: flex;
    justify-content: center;
}
.text-error{
    color: red;
    font-weight: bold;
}
</style>