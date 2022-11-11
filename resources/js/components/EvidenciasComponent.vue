<style type="text/css">
    #viewimg img {
        height: 100%;
        padding: 0 0.5rem;
        display: inline-flex;
    }
</style>
<template>
    <div>
        <!--<div style="width: 100%; text-align: right; margin-top: 20px;">
            <button class="btn btn-warning" type="button" v-on:click="verCps()">
                Ver CP's
            </button>
            <button class="btn btn-primary" type="button" v-on:click="changeFlagEvidences()">
                Mostrar/Esconder
            </button>
        </div><br><br>-->
        <div v-if="showEvidences" style="margin-top: 40px;">
            <div v-if="resultadoFlag == 'PENDIENTE'">
                <button type="button" style="background: #ff287b; border: none;" class="btn btn-primary" v-on:click="changeFlag()">Agregar evidencia (Portapapeles)</button>
                <button type="button" style="background: #ff287b; border: none;" class="btn btn-primary" v-on:click="changeFlagArchivo()">Agregar evidencia (Archivo)</button>
            </div><br>
            <div v-if="showForm">
                <form @submit="createEvidencia" enctype="multipart/form-data">
                    <input type="text" id="Id" v-model="evidencia.cp_id" hidden>
                    <div id="viewimg" @paste="pasteFunction" @keyup.delete="deleteFunction" style="width: 100%; height: 200px; display: flex; background-color: #C1C1C1; padding: 20px; position: relative; z-index: 1;" contenteditable="true" class="overflow-auto"><span> </span><span contenteditable='false' style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); cursor: alias; z-index: -1; text-align: center;">Copie aquí su evidencia</span></div>
                    <!--<div class="mb-3">
                        <label for="Imagen" class="form-label">Imagen</label>
                        <input type="file" class="form-control" name="Imagen" id="Imagen" v-on:change="onFileChange">
                    </div>-->
                    <input type="text" id="path" v-model="evidencia.path" hidden>
                    <div class="mb-3">
                        <br><label for="Resultado" class="form-label">Comentario</label>
                        <textarea type="text" class="form-control" id="Resultado" v-model="evidencia.comentario" rows="4" required></textarea>
                        <small id="comentario" class="form-text text-muted">*Ingrese un comentario obligatoriamente.</small>
                    </div><br>
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <br><br>
                </form>
            </div>
            <div v-if="showFormArchivo">
                <form @submit="createEvidencia" enctype="multipart/form-data">
                    <input type="text" id="Id" v-model="evidencia.cp_id" hidden>
                    <div class="mb-3">
                        <label for="Imagen" class="form-label">Imagen</label>
                        <input type="file" class="form-control" name="Imagen" id="Imagen" v-on:change="onFileChange">
                    </div>
                    <input type="text" id="path" v-model="evidencia.path" hidden>
                    <div class="mb-3">
                        <br><label for="Resultado" class="form-label">Comentario</label>
                        <textarea type="text" class="form-control" id="Resultado" v-model="evidencia.comentario" rows="4" required></textarea>
                        <small id="comentario" class="form-text text-muted">*Ingrese un comentario obligatoriamente</small>
                    </div><br>
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <br><br>
                </form>
            </div>

            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr align="center">
                        <th scope="col">#</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Comentario</th>
                        <th scope="col">Fecha y hora</th>
                        <th scope="col" v-if="resultadoFlag == 'PENDIENTE'">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(evidencia, index) in evidencias" :key="evidencia.id">
                        <td>{{ index+1 }}</td>
                        <!--<td><img :src="''+evidencia.path" style="width: 150px; object-fit: cover;"></td>-->
                        <td align="center"><img v-bind:src="''+evidencia.imagen" style="width: 150px; object-fit: cover;"></td>
                        <td>{{ evidencia.comentario }}</td>
                        <td align="center">{{ evidencia.fecha_hora }}</td>
                        <td v-if="resultadoFlag == 'PENDIENTE'" align="center">
                            <a type="button" class="btn btn-danger" style="background: rgb(255, 40, 123);" @click="deleteEvidencia(evidencia.id)" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Evidencia">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!--<div class="card" style="margin-bottom:100px; text-align: center;">
                <div class="card-header"><strong>Decisíón</strong></div>
                <div class="card-body">
                    
                    <a type="button" id="desestimar" class="btn btn-primary" style="background: #013461; border: none; margin-right: 10px;" href="{{ route('desestimacp', {{ this.idCp }}) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Desestimado" onclick="return confirm('¿Está seguro(a)?')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a type="button" id="fallido" class="btn btn-primary" style="background: #FF287A; border: none; margin-right: 10px;" href="{{ route('fallacp', {{ idCp }}) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Fallido" onclick="return confirm('¿Está seguro(a)?')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-exclamation-diamond" viewBox="0 0 16 16">
                            <path d="M6.95.435c.58-.58 1.52-.58 2.1 0l6.515 6.516c.58.58.58 1.519 0 2.098L9.05 15.565c-.58.58-1.519.58-2.098 0L.435 9.05a1.482 1.482 0 0 1 0-2.098L6.95.435zm1.4.7a.495.495 0 0 0-.7 0L1.134 7.65a.495.495 0 0 0 0 .7l6.516 6.516a.495.495 0 0 0 .7 0l6.516-6.516a.495.495 0 0 0 0-.7L8.35 1.134z"/>
                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                        </svg>
                    </a>
                    <a type="button" id="exitoso" class="btn btn-primary" style="background: #019500; border: none; margin-right: 10px;" href="{{ route('exitocp', {{ idCp }}) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Exitoso" onclick="return confirm('¿Está seguro(a)?')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>                                   
                    </a>
                </div>
            </div>-->
        </div><br><br><br>
    </div>
</template>

<script>
import { stringLiteral } from '@babel/types';

    export default {
        
        props: {

            idCp: Number,
            idInc: Number,
            resultadoCp: String

        },

        created(){

            //console.log(this.aprobadoCp)
        },

        data(){
            return{

                resultadoFlag: this.resultadoCp,

                testCaseIdProp: null,
                showForm: false,
                showFormArchivo: false,
                showEvidences: true,
                evidencias:[],
                evidencia:{

                    cp_id: this.idCp,
                    inc_id: this.idInc,
                    imagen: [],
                    path: "",
                    comentario: "",
                    fecha_hora: "",
                    ola: null
                },

                /* TESTING */

                images:[]
            }
        },

        computed:{
            //console.log(this.aprobadoCp)
        },

        mounted() {

            this.showEvidencias();
            //console.log(this.idInc)
            //console.log(this.aprobadoCp)
        },

        methods:{

            showEvidencias(){

                if(this.idCp != null){

                    axios.get('/api/evidencias/'+this.idCp+'/'+'0')
                            .then(response=>{
                                this.evidencias = response.data
                            })
                            .catch(error=>{
                                alert(error);
                                console.log(error)
                            })
                } else {

                    axios.get('/api/evidencias/'+this.idInc+'/'+'1')
                            .then(response=>{
                                this.evidencias = response.data
                            })
                            .catch(error=>{
                                alert(error);
                                console.log(error)
                            })
                }
            },

            createEvidencia(){

                axios.post('/api/evidencias', this.evidencia)
                .then(response=>{
                    
                    if(this.idCp != null){
                        
                        window.location.href = '/vistacp/' + this.idCp;
                    } else {

                        window.location.href = '/vistainc/' + this.idInc;
                    }
                })
                .catch(error=>{
                    alert(error);
                    console.log(error);
                })
            },

            /*createEvidenciaArchivo(e){
                
                // Kata v0.3.0
                
                e.preventDefault();
                let existingObj  = this;

                const config = {
                    headers: { 
                        'content-type': 'multipart/form-data' 
                    }
                }

                let data = new FormData();
                data.append('cp_id', this.evidencia.cp_id);
                data.append('imagen', this.evidencia.imagen);
                data.append('path', this.evidencia.path);
                data.append('comentario', this.evidencia.comentario);
                data.append('fecha_hora', this.evidencia.fecha_hora);
                data.append('ola', this.evidencia.ola);

                axios.post('/api/evidencias', data, config)
                .then(response=>{
                    //this.$router.push({name:"mostrarDocumentos"});
                    //console.log(response.data)
                    window.location.href = '/vistacp/' + this.idCp;
                })
                .catch(error=>{
                    alert(error);
                    console.log(error);
                })
                //alert(this.evidencia.imagen);
            },*/

            deleteEvidencia(idEv){

                if(confirm('¿Está seguro(a)?')){

                    axios.delete('/api/evidencias/' + idEv)
                        .then(response=>{

                            if(this.idCp != null){
                        
                                window.location.href = '/vistacp/' + this.idCp;
                            } else {

                                window.location.href = '/vistainc/' + this.idInc;
                            }
                        })
                        .catch(error=>{
                            alert(error);
                        })
                }
            },

            changeFlag(){

                if(!this.showForm){

                    this.showForm = true;
                    this.showFormArchivo = false;
                } else {

                    this.showForm = false;
                }
            },

            changeFlagArchivo(){

                if(!this.showFormArchivo){

                    this.showFormArchivo = true;
                    this.showForm = false
                } else {

                    this.showFormArchivo = false;
                }
            },

            changeFlagEvidences(){

                if(!this.showEvidences){

                    this.showEvidences = true;
                } else {

                    this.showEvidences = false;
                }  
            },

            onFileChange(e){

                // Kata v0.3.0
                //this.evidencia.imagen = e.target.files[0];

                // Testing

                var self = this;

                var reader = new FileReader()
                    reader.readAsDataURL(e.target.files[0])
                    reader.onload = function () {
                        self.evidencia.imagen[0] = reader.result;
                        //console.log(self.evidencia.imagen[0]);
                    };
            },

            verCps(){

                window.location.href = '/dashboard';
            },

            pasteFunction(pasteEvent){

                //console.log(event.clipboardData.items[0])
                //console.log(pasteEvent.clipboardData.items[0]);

                /*var self = this;

                var reader = new FileReader()
                    reader.readAsDataURL(pasteEvent.clipboardData.items[0].getAsFile())
                    reader.onload = function () {
                        self.evidencia.imagen = reader.result;
                        //console.log(reader.result);
                    };*/

                /* TESTING */

                var self = this;

                var reader = new FileReader()
                    reader.readAsDataURL(pasteEvent.clipboardData.items[0].getAsFile())
                    reader.onload = function () {
                        self.evidencia.imagen.push(reader.result);
                        //console.log(self.evidencia.imagen);
                    };
            },

            deleteFunction(deleteEvent){

                //console.log('eliminado');
                this.evidencia.imagen.splice(-1);
            }
        }
    }
</script>
