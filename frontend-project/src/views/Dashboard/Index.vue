<script setup>
import Table from './Components/Table.vue';

</script>

<template>
    <Table
        :classes="classesTableArray" 
        :columns="columnsTableArray"
        :columnsRegisters="columnsRegistersTableArray"
        :rows="rowsTableObject" 
        :pagination="rowsTablePagination" 
        :itemsPerPage="itemsTablePerPage"
        :paginationMax="paginationTableLimit"

        :buttons="['delete', 'view', 'edit']"
        :checkboxes="true"
        
        @paginate="getPaginate"
        @specific-pagination="getSpecificPage"
        @searched-value="getTableDataSearched" 
        
        @destroy-register="onDestroyRegister"
        @show-register="onShowRegister"
        @edit-register="onEditRegister" />
</template>

<script>
import axios from 'axios';

export default {
    emit: [ 'nextPage', 'specific-pagination', 'searched-value', 'destroy-register', 'edit-register', 'show-register' ],
    components: {
        Table,
    },
    data(){
        return {
            classesTableArray: [
                'table-hover', 'striped', 'rounded', 'table-striped',
            ],
            columnsTableArray: [
                'Nome', 'Email', 'Data Cadastro', 'Aniversário',
            ],
            columnsRegistersTableArray: [
                'name', 'email', 'created_at', 'birthday',
            ],
            rowsTableObject: [],
            rowsTablePagination: {
                page: 0, pages: 0
            },
            itemsTablePerPage: 10,
            paginationTableLimit: 3,
            currentTablePage: 1,
        }
    },
    mounted(){
        this.getTableData();
    },

    methods: {
        async onDestroyRegister(value){
            // lógica
            console.log('onDestroyRegister', value)
        },
        async onEditRegister(value){
            // lógica
            console.log('onEditRegister', value)
        },
        async onShowRegister(value){
            // lógica
            console.log('onShowRegister', value)
        },

        async getTableData(){
            await axios.post('http://127.0.0.1:8000/api/getUsers', {
                itemsPerPage: this.itemsTablePerPage,
                page: this.currentTablePage,
            }).then( response => {
                this.rowsTableObject = response.data.data;
                delete this.rowsTableObject.last_page;
                this.rowsTablePagination.page = response.data.current_page;
                this.rowsTablePagination.pages = response.data.last_page;
                // console.log(response.data);
            }).catch( error => {
                console.log(error);
            });
        },

        async getPaginate(data){
            await axios.post('http://127.0.0.1:8000/api/getUsers', {
                itemsPerPage: this.itemsTablePerPage,
                page: data.page,
                searched: data.value
            }).then( response => {
                this.rowsTableObject = response.data.data;
                delete this.rowsTableObject.last_page;
                this.rowsTablePagination.page = response.data.current_page;
                this.rowsTablePagination.pages = response.data.last_page;
                // console.log(response.data);
            }).catch( error => {
                console.log(error);
            });
        },
        async getSpecificPage(data){
            await axios.post('http://127.0.0.1:8000/api/getUsers', {
                itemsPerPage: this.itemsTablePerPage,
                page: data.page,
                searched: data.value
            }).then( response => {
                this.rowsTableObject = response.data.data;
                delete this.rowsTableObject.last_page;
                this.rowsTablePagination.page = response.data.current_page;
                this.rowsTablePagination.pages = response.data.last_page;
                // console.log(response.data);
            }).catch( error => {
                console.log(error);
            });
        },

        async getTableDataSearched(data){
            await axios.post('http://127.0.0.1:8000/api/getUsers', {
                itemsPerPage: this.itemsTablePerPage,
                page: this.currentTablePage,
                searched: data.value
            }).then( response => {
                this.rowsTableObject = response.data.data;
                delete this.rowsTableObject.last_page;
                this.rowsTablePagination.page = response.data.current_page;
                this.rowsTablePagination.pages = response.data.last_page;
                // console.log(response.data);
            }).catch( error => {
                console.log(error);
            });
        },
    }
}
</script>
