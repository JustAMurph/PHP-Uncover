<template>
    <div id="file" class="row">
        <div class="col">
            <div class="card mb-3">
                <div class="card-body">

                    <div v-if="in_progress">
                        <h2>Please Wait....</h2>
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <div v-else-if="!scan_id">
                        <div class="mb-3">
                            <label for="name" class="form-label">Application:</label>
                            <select id="application" name="application" class="form-control"
                                    v-model="application_id">

                                <option v-for="application in applications" :value="application.id">{{ application.name}}</option>
                            </select>
                            <div id="applicationHelp" class="form-text">The application to associate the scan with.</div>
                        </div>
                        <div class="mb-3">
                            <label for="plugins" class="form-label">Select File</label>
                            <input type="file" @change="uploadFile" ref="file" class="form-control">
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" v-model="customConfig">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Use Custom Config
                                </label>
                            </div>
                        </div>

                        <div class="mb-3" v-if="customConfig">
                            <label for="plugins" class="form-label">Config File:</label>
                            <input type="file" @change="uploadConfig" ref="config" class="form-control">
                        </div>

                        <p>If you do not have any source code to scan please visit our sample source code page. <a href="/samples">Sample Source Code</a></p>
                    </div>

                    <div v-else>
                        <h2>Scan Complete! </h2>
                        <p>View the report here: <a target="_blank" :href="getScanReportUrl()">View Report</a><br/>
                            Alternatively, go back to the <a href="/scans/">Scans listing page.</a>
                        </p>
                    </div>
                </div>
            </div>

            <button @click.prevent="goBack()" class="btn btn-outline-secondary">
                <i class="bi bi-chevron-double-left"></i> Back
            </button>

            <button v-if="!scan_id && !in_progress" @click.prevent="startScan" class="btn btn-primary text-white">
                <i class="bi bi-bullseye"></i> Start Scan
            </button>

        </div>
    </div>
</template>

<script>
export default {
    name: "FileUploadComponent",
    props: ['applications'],
    data() {
        return {
            "application_id": null,
            "file": null,
            "scan_id": false,
            "config": null,
            "customConfig": false,
            "in_progress": false
        }
    },
    created() {
        console.log(this.applications);
    },
    methods: {
        goBack() {
            console.log(this);
            window.location.href = '/scans';
        },
        uploadFile(t) {
            console.log(t)
            this.file = this.$refs.file.files[0];
            console.log('File: ', this.file)
        },
        uploadConfig() {
            this.config = this.$refs.config.files[0];
            console.log('Config: ', this.config)
        },
        getScanReportUrl() {
            return '/scans/view/' + this.scan_id
        },
        startScan() {
            console.log(this.file);

            const formData = new FormData();
            formData.append('file', this.file);
            formData.append('config', this.config)
            formData.append("application_id", this.application_id);
            const headers = { 'Content-Type': 'multipart/form-data' };
            this.in_progress = true
            axios.post('/scans/start', formData, { headers }).then((res) => {
                res.data.files; // binary representation of the file
                res.status; // HTTP status

                this.in_progress = false
                console.log(res.data);
                if (res.status === 200) {
                    this.scan_id = res.data.scan_id;
                } else {
                    alert('Error with response.');
                }
            });
        }
    }
}
</script>

<style scoped>

</style>
