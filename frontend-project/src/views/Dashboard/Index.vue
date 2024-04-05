<script setup>
import Table from './Components/Table.vue';

</script>

<template>
    <Table
        :columns="columnsTableArray"
        :columnsRegisters="columnsRegistersTableArray"
        :rows="rowsTableObject" 
        :pagination="rowsTablePagination" 
        :itemsPerPage="itemsTablePerPage"
        :paginationMax="paginationTableLimit"
        :totalRegisters="totalRegisters"
        :from="fromRegister"
        :to="toRegister"

        :buttons="rowButtons"
        :deleteAllButton="true"
        :checkboxes="true"

        @destroy-register="onDestroyRegister"
        @show-register="onShowRegister"
        @edit-register="onEditRegister"
        @destroy-many-registers="onDestroyManyRegisters"

        @paginate="getTableData"
        @specific-pagination="getTableData"
        @searched-value="getTableData"
        @items-per-page="getTableData"
        @sort-by="getTableData"
        />
</template>

<script>
import axios from 'axios';
export default {
    emit: [
        'sort-by' ,
        'nextPage', 
        'specific-pagination', 
        'searched-value', 
        'destroy-register', 
        'edit-register', 
        'show-register', 
        'destroy-many-registers', 
        'items-per-page' 
    ],
    components: {
        Table,
    },
    data(){
        return {
            requestUrl: 'http://127.0.0.1:8000/api/getUsers',
            columnsTableArray: [ 'Nome', 'Email', 'Data Cadastro', 'Aniversário', ],
            columnsRegistersTableArray: [ 'name', 'email', 'created_at', 'birthday', ],
            rowButtons: [ 'delete', 'view', 'edit' ],
            rowsTableObject: [],
            rowsTablePagination: { page: 0, pages: 0 },
            itemsTablePerPage: 10,
            paginationTableLimit: 3,
            currentTablePage: 1,
            totalRegisters: null,
            fromRegister: null,
            toRegister: null,
        }
    },
    mounted(){
        this.loadTableData();
    },
    methods: {
        async onDestroyManyRegisters(value){
            console.log('onDestroyManyRegisters', value);
        },
        async onDestroyRegister(value){
            console.log('onDestroyRegister', value);
        },
        async onEditRegister(value){
            console.log('onEditRegister', value);
        },
        async onShowRegister(value){
            console.log('onShowRegister', value);
        },
        async loadTableData(){
            await axios.post(this.requestUrl, {
                itemsPerPage: this.itemsTablePerPage,
                page: this.currentTablePage,
            }).then( response => {
                this.totalRegisters             = response.data.total;
                this.rowsTableObject            = response.data.data; delete this.rowsTableObject.last_page;
                this.rowsTablePagination.page   = response.data.current_page;
                this.rowsTablePagination.pages  = response.data.last_page;
                this.fromRegister               = response.data.from;
                this.toRegister                 = response.data.to;
            }).catch( error => {
                console.log(error);
            });
        },
        async getTableData(data){
            await axios.post(this.requestUrl, {
                itemsPerPage: data.perpage,
                page: data.page,
                searched: data.value,
                sortBy: data.sortBy,
                orderAs: data.orderAs,
            }).then( response => {
                this.totalRegisters             = response.data.total;
                this.rowsTableObject            = response.data.data; delete this.rowsTableObject.last_page;
                this.rowsTablePagination.page   = response.data.current_page;
                this.rowsTablePagination.pages  = response.data.last_page;
                this.fromRegister               = response.data.from;
                this.toRegister                 = response.data.to;
            }).catch( error => {
                console.log(error);
            });
        },
    }
}
</script>
