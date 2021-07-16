<template>
    <div class="container">
        <div class="modal" :class="{mostrar:modal}">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{tituloModal}}</h4>
                    <button @click="cerrarModal();" type="button" class="close" >&times;</button>
                </div>
                <div class="modal-body">
                    <div>
                        <label for="nombre_producto"></label>
                        <input v-model="producto.nombre_producto" placeholder="Nombre del Producto" id="nombre_producto" type="text" class="form-control">
                        <span class="text-danger" v-if="errores.nombre_producto">{{errores.nombre_producto[0]}}></span>
                    </div>
                    <div>
                        <label for="marca_producto"></label>
                        <input v-model="producto.marca_producto" placeholder="Marca del Producto" id="marca_producto" type="text" class="form-control">
                        <span class="text-danger" v-if="errores.marca_producto">{{errores.marca_producto[0]}}></span>
                    </div>
                    <div>
                        <label for="descripcion_producto"></label>
                        <input v-model="producto.descripcion_producto" placeholder="Descripcion del Producto" id="descripcion_producto" type="text" class="form-control">
                        <span class="text-danger" v-if="errores.descripcion_producto">{{errores.descripcion_producto[0]}}></span>
                    </div>
                    <div>
                        <label for="precio_producto"></label>
                        <input v-model="producto.precio_producto" placeholder="Precio del Producto" id="precio_producto" type="number" class="form-control">
                        <span class="text-danger" v-if="errores.precio_producto">{{errores.precio_producto[0]}}></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"  @click="guardar();">Guardar Cambios</button>
                    <button type="button" class="btn btn-danger"  @click="cerrarModal();">Cancelar</button>
                </div>
                </div>
            </div>
        </div>
        <h1 class="text-center">Manteminimiento Productos</h1>
        <div class="row">
            <div class="col-12">
                <button @click="modificar=false; abrirModal();" type="button" class="btn btn-success">Agregar Registro</button>
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">id</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Precio</th>
                        <th scope="col" colspan="2" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="pro in productos" :key="pro.id">
                            <th scope="row">{{pro.id}}</th>
                            <th>{{pro.nombre_producto}}</th>
                            <th>{{pro.marca_producto}}</th>
                            <th>{{pro.descripcion_producto}}</th>
                            <th>{{pro.precio_producto}}</th>
                            <th>
                                <button @click="modificar=true; abrirModal(pro);" class="btn btn-warning">Editar</button>
                            </th>
                            <td>
                            <button @click="eliminar(pro.id);" class="btn btn-danger">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
 export default{
     data(){
         return{
             producto:{
                 nombre_producto:'',
                 marca_producto:'',
                 descripcion_producto:'',
                 precio_producto:'',
             },
             id:0,
             modificar:true,
             modal:0,
             tituloModal:'',
             productos:[],
             errores:{},
         };
     },

     methods: {
        async listar(){
            const res = await axios.get('/productos');
            this.productos = res.data;
        },
        async eliminarSweet(id){
         const res = await axios.delete('/productos/' + id);
              
        },
        async eliminar(id){
          Swal.fire({
            title: 'Advertencia',
            icon: 'warning',
            text: '¿Desea eliminar el registro?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Eliminar`,
            denyButtonText: `Cancelar`,
            }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire('Exito', 'El registro se elimino correctamente', 'success')
                this.eliminarSweet(id);
                this.listar();
            } else if (result.isDenied) {
                Swal.fire('Informacion', 'El registro no se ha eliminado', 'info')
            }
            });
        },
        async guardar(){
            try {
                if(this.modificar){
                    const res = await axios.put('/productos/' +this.id, this.producto);
                    Swal.fire('Exito', 'El registro se modifico correctamente', 'success');
                }else{
                    const res = await axios.post('/productos',this.producto);
                    Swal.fire('Exito', 'El registro se guardo correctamente', 'success');
                }
                this.cerrarModal();
                this.listar();
            } catch (error) {
                if(error.response.data){
                    this.errores = error.response.data.errors
                }
            }
        },
        abrirModal(data={}){
            this.modal = 1;
            if(this.modificar){
                this.id = data.id;
                this.tituloModal = "Modificar Registro";
                this.producto.nombre_producto=data.nombre_producto;
                this.producto.marca_producto=data.marca_producto;
                this.producto.descripcion_producto=data.descripcion_producto;
                this.producto.precio_producto=data.precio_producto;
            }else{
                this.id = 0;
                this.tituloModal = "Nuevo Registro";
                this.producto.nombre_producto='';
                this.producto.marca_producto='';
                this.producto.descripcion_producto='';
                this.producto.precio_producto='';
            }
        },
        cerrarModal(){
            this.modal = 0;
            this.errores={};
        },
     },

    created(){
        this.listar();
        
    },
 }
</script>
<style>
.mostrar{
    display: list-item;
    opacity: 1;
}
</style>