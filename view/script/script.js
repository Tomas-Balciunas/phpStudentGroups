new Vue({
    el: '#app',
    data: {
        data: '',
        err: ''
    },
    methods: {
        updateStudent: function (id) {
            axios({
                method: 'post',
                url: 'update-student/' + id,
                data: new FormData(document.getElementById('updateStud' + id)),
                config: {
                    headers: { 'Content-Type': 'multipart/form-data' }
                }
            })
                .then((data) => { this.err = data.data })
                .then(setTimeout(() => this.fetchData(), 200))
                .catch(function (response) { console.log('error', response); });
        },

        deleteStudent: function (id) {
            axios({
                method: 'post',
                url: 'delete-student/' + id,
                data: new FormData(document.getElementById('deleteStud' + id)),
                config: {
                    headers: { 'Content-Type': 'multipart/form-data' }
                }
            })
                .then((data) => { this.err = data.data })
                .then(setTimeout(() => this.fetchData(), 200))
                .catch(function (response) { console.log('error', response); });
        },

        addStudent: function (id) {
            axios({
                method: 'post',
                url: 'add-student/' + id,
                data: new FormData(document.getElementById('addStud' + id)),
                config: {
                    headers: { 'Content-Type': 'multipart/form-data' }
                }
            })
                .then((data) => { this.err = data.data })
                .then(setTimeout(() => this.fetchData(), 200))
                .catch(function (response) { console.log('error', response); });
        },

        fetchData: function () {
            axios.get('data').then((response) => {
                this.data = response.data;
            }).catch((error) => {
                console.log(error);
            });
        }
    },
    created() {
        this.fetchData();
        this.timer = setInterval(this.fetchData, 10000);
    }
});