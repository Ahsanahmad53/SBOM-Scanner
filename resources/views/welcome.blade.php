<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8" />
    <title>Security Scan Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
<div id="app">
    <h1>Projects</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Name</th>
                <th>Repo URL</th>
                <th>Vulnerabilities</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="project in projects" :key="project.id">
                <td>@{{ project.name }}</td>
                <td><a :href="project.repo_url" target="_blank">@{{ project.repo_url }}</a></td>
                <td>@{{ project.vulnerabilities_count }}</td>
                <td><button @click="selectProject(project)">View Vulnerabilities</button></td>
            </tr>
        </tbody>
    </table>

    <div v-if="selectedProject" style="margin-top: 30px;">
        <h2>Vulnerabilities for @{{ selectedProject.name }}</h2>
        <label>Filter by Severity:
            <select v-model="filterSeverity" @change="fetchVulnerabilities">
                <option value="">All</option>
                <option>LOW</option>
                <option>MEDIUM</option>
                <option>HIGH</option>
                <option>CRITICAL</option>
            </select>
        </label>
        <table border="1" cellpadding="5" cellspacing="0" style="margin-top: 10px;">
            <thead>
                <tr>
                    <th>CVE ID</th>
                    <th>Package</th>
                    <th>Installed Version</th>
                    <th>Fixed Version</th>
                    <th>Severity</th>
                    <th>Title</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="vul in vulnerabilities" :key="vul.id">
                    <td>@{{ vul.cve_id || '-' }}</td>
                    <td>@{{ vul.package }}</td>
                    <td>@{{ vul.installed_version || '-' }}</td>
                    <td>@{{ vul.fixed_version || '-' }}</td>
                    <td>@{{ vul.severity }}</td>
                    <td>@{{ vul.title }}</td>
                </tr>
                <tr v-if="vulnerabilities.length === 0">
                    <td colspan="6">No vulnerabilities found.</td>
                </tr>
            </tbody>
        </table>
        <button @click="selectedProject = null" style="margin-top: 10px;">Back to Projects</button>
    </div>
</div>

<script>
new Vue({
    el: '#app',
    data: {
        projects: [],
        selectedProject: null,
        vulnerabilities: [],
        filterSeverity: '',
    },
    created() {
        this.fetchProjects();
    },
    methods: {
        fetchProjects() {
            axios.get('/api/projects')
                .then(res => {
                    this.projects = res.data;
                });
        },
        selectProject(project) {
            this.selectedProject = project;
            this.filterSeverity = '';
            this.fetchVulnerabilities();
        },
        fetchVulnerabilities() {
            let url = `/api/projects/${this.selectedProject.id}/vulnerabilities`;
            if (this.filterSeverity) {
                url += `?severity=${this.filterSeverity}`;
            }
            axios.get(url)
                .then(res => {
                    this.vulnerabilities = res.data;
                });
        }
    }
});
</script>
</body>
</html>