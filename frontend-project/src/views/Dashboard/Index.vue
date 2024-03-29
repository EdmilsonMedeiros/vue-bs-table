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

        :totalColumnsRegisters="totalColumnsRegisters"
        :buttons="['delete', 'view', 'edit']"
        :deleteAllButton="true"
        :checkboxes="true"
        
        @paginate="getPaginate"
        @specific-pagination="getSpecificPage"
        @searched-value="getTableDataSearched" 
        
        @destroy-register="onDestroyRegister"
        @show-register="onShowRegister"
        @edit-register="onEditRegister"
        @destroy-many-registers="onDestroyManyRegisters"
        @items-per-page="getItemsPerPage"
        @sort-by="getSortBy"/>
</template>

<script>
import axios from 'axios';
export default {
    emit: ['sort-by' ,'nextPage', 'specific-pagination', 'searched-value', 'destroy-register', 'edit-register', 'show-register', 'destroy-many-registers', 'items-per-page' ],
    components: {
        Table,
    },
    data(){
        return {
            requestUrl: 'http://127.0.0.1:8000/api/getUsers',
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
            totalColumnsRegisters: Number,
        }
    },
    mounted(){
        this.getTableData();
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
        async getTableData(){
            await axios.post(this.requestUrl, {
                itemsPerPage: this.itemsTablePerPage,
                page: this.currentTablePage,
            }).then( response => {
                this.rowsTableObject = response.data.data;
                this.totalColumnsRegisters = response.data.total;
                delete this.rowsTableObject.last_page;
                this.rowsTablePagination.page = response.data.current_page;
                this.rowsTablePagination.pages = response.data.last_page;
            }).catch( error => {
                console.log(error);
            });
        },
        async getSortBy(data){
            console.log(data);
            this.itemsTablePerPage = data.perpage;
            await axios.post(this.requestUrl, {
                itemsPerPage: data.perpage,
                page: data.page,
                searched: data.value,
                sortBy: data.sortBy,
            }).then( response => {
                this.totalColumnsRegisters = response.data.total;
                this.rowsTableObject = response.data.data;
                delete this.rowsTableObject.last_page;
                this.rowsTablePagination.page = response.data.current_page;
                this.rowsTablePagination.pages = response.data.last_page;
            }).catch( error => {
                console.log(error);
            });
        },
        async getItemsPerPage(data){
            this.itemsPerPage = data.perpage;
            await axios.post(this.requestUrl, {
                itemsPerPage: data.perpage,
                page: data.page,
                searched: data.value,
                sortBy: data.sortBy,
            }).then( response => {
                this.totalColumnsRegisters = response.data.total;
                this.rowsTableObject = response.data.data;
                delete this.rowsTableObject.last_page;
                this.rowsTablePagination.page = response.data.current_page;
                this.rowsTablePagination.pages = response.data.last_page;
            }).catch( error => {
                console.log(error);
            });
        },
        async getPaginate(data){
            this.itemsTablePerPage = data.perpage;
            await axios.post(this.requestUrl, {
                itemsPerPage: data.perpage,
                page: data.page,
                searched: data.value,
                sortBy: data.sortBy,
            }).then( response => {
                this.totalColumnsRegisters = response.data.total;
                this.rowsTableObject = response.data.data;
                delete this.rowsTableObject.last_page;
                this.rowsTablePagination.page = response.data.current_page;
                this.rowsTablePagination.pages = response.data.last_page;
            }).catch( error => {
                console.log(error);
            });
        },
        async getSpecificPage(data){
            this.itemsTablePerPage = data.perpage;
            await axios.post(this.requestUrl, {
                itemsPerPage: data.perpage,
                page: data.page,
                searched: data.value,
                sortBy: data.sortBy,
            }).then( response => {
                this.totalColumnsRegisters = response.data.total;
                this.rowsTableObject = response.data.data;
                delete this.rowsTableObject.last_page;
                this.rowsTablePagination.page = response.data.current_page;
                this.rowsTablePagination.pages = response.data.last_page;
            }).catch( error => {
                console.log(error);
            });
        },
        async getTableDataSearched(data){
            this.itemsTablePerPage = data.perpage;
            await axios.post(this.requestUrl, {
                itemsPerPage: this.itemsTablePerPage,
                page: this.currentTablePage,
                searched: data.value,
                sortBy: data.sortBy,
            }).then( response => {
                this.totalColumnsRegisters = response.data.total;
                this.rowsTableObject = response.data.data;
                delete this.rowsTableObject.last_page;
                this.rowsTablePagination.page = response.data.current_page;
                this.rowsTablePagination.pages = response.data.last_page;
            }).catch( error => {
                console.log(error);
            });
        },
    }
}
</script>
