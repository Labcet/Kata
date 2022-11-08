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
                        <input type="text" class="form-control" id="Resultado" v-model="evidencia.comentario" required>
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
                        <input type="text" class="form-control" id="Resultado" v-model="evidencia.comentario" required>
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
        </div><br><br><br>
    </div>
</template>

<script>
import { stringLiteral } from '@babel/types';

    export default {
        
        props: {

            idCp: Number,
            resultadoCp: String,
            tipoCp: String

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
                    imagen: [],
                    path: "",
                    comentario: "",
                    fecha_hora: "",
                    ola: null,
                    tipo: this.tipoCp
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
            //console.log(this.idCp)
            //console.log(this.aprobadoCp)
        },

        methods:{

            showEvidencias(){

                axios.get('/api/evidencias/' + this.idCp)
                .then(response=>{
                    this.evidencias = response.data
                })
                .catch(error=>{
                    alert(error);
                    console.log(error)
                })
            },

            createEvidencia(){

                axios.post('/api/evidencias', this.evidencia)
                .then(response=>{
                    //this.$router.push({name:"mostrarDocumentos"});
                    //alert(response.data);
                    window.location.href = '/vistacp/' + this.idCp;
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

                //console.log(idEv);
                axios.delete('/api/evidencias/' + idEv)
                    .then(response=>{
                        window.location.href = '/vistacp/' + this.idCp;
                    })
                    .catch(error=>{
                        alert(error);
                    })
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
