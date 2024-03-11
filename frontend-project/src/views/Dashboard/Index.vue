<script setup>
import Table from './Components/Table.vue';

</script>

<template>

    <Table 
        :classes="classesTableArray" 
        :columns="columnsTableArray" 
        :rows="rowsTableObject" 
        :pagination="rowsTablePagination" 
        :itemsPerPage="itemsTablePerPage"
        :paginationMax="paginationTableLimit"
        @paginate="paginate"
        @specific-pagination="specificPagination" />

</template>

<script>
import axios from 'axios';

export default {
    emit: [ 'nextPage', 'specific-pagination' ],
    components: {
        Table,
    },
    data(){
        return {
            classesTableArray: [
                'table-hover', 'striped', 'rounded', 'table-striped',
            ],
            columnsTableArray: [
                'Nome', 'Email', 'Data Cadastro'
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
        getTableData(){
            axios.post('http://127.0.0.1:8000/api/getUsers', {
                itemsPerPage: this.itemsTablePerPage,
                page: this.currentTablePage,
            }).then( response => {
                this.rowsTableObject = response.data.data;
                this.rowsTablePagination.page = response.data.current_page;
                this.rowsTablePagination.pages = response.data.last_page;
                console.log(response.data);
            }).catch( error => {
                console.log(error);
            });
        },

        paginate(page){
            axios.post('http://127.0.0.1:8000/api/getUsers', {
                itemsPerPage: this.itemsTablePerPage,
                page: page,
            }).then( response => {
                this.rowsTableObject = response.data.data;
                this.rowsTablePagination.page = response.data.current_page;
                this.rowsTablePagination.pages = response.data.last_page;
                // console.log(response.data);
            }).catch( error => {
                console.log(error);
            });
        },
        specificPagination(page){
            console.log("SpecificPage: " + page);
            axios.post('http://127.0.0.1:8000/api/getUsers', {
                itemsPerPage: this.itemsTablePerPage,
                page: page,
            }).then( response => {
                this.rowsTableObject = response.data.data;
                this.rowsTablePagination.page = response.data.current_page;
                this.rowsTablePagination.pages = response.data.last_page;
                // console.log(response.data);
            }).catch( error => {
                console.log(error);
            });
        }
    }
}
</script>
