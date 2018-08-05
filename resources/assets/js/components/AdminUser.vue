<template>
    <div>
        <h3 class="admin-panel-title">List of Users</h3>
        <v-client-table
                :data="tableData"
                :columns="columns"
                :options="options">
        </v-client-table>
    </div>
</template>
<script>
    export default{
        mounted() {
            this.fetchBlog();
        },
        data(){
            return{
                columns: ['id','email','first_name','last_name','nick_name','gender', 'last_login_time','activation_time'],
                tableData: [],
                options: {
                    compileTemplates: true,
                    pagination: {
                        dropdown:true,
                        chunk:10
                    },
                    perPage: 50,
                    filterByColumn: false,
                    texts: {
                        filter: "Search: "
                    },
                    datepickerOptions: {
                        showDropdowns: true
                    },
                    sortIcon: {
                        base:'fa',
                        up:'fa-chevron-up',
                        down:'fa-chevron-down'
                    },
                   // sortable: ['id','title','status'],
                    orderBy:{
                        column: 'id',
                        ascending: false
                    }

                }
            }
        },
        methods:{
            fetchBlog:function(){
                return this.$http.get("/admin/user-data")
                    .then((resp)=>{
                        console.log(resp);
                        this.tableData = resp.body;
                        return true;
                    }).catch(function (err) {
                    }).bind(this);
            },
            deleteBlog:function (id) {
                console.log(id);
            }
        }
    }

</script>
