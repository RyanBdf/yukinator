node {
    stage('checkout') {
        deleteDir()
        checkout scm
    }
    stage('Prepare env'){
        preparingEnv()
    }
    stage('Build Containers') {
        yukinator = docker.build('yukinator', '--no-cache -f _build/docker/php-apache/Dockerfile .')
        yukinator.run('-p 8088:80 --network land_default --name=yukinator --restart=always')
    }
}

def preparingEnv(){
    def isRunning = sh(script: 'docker ps -a -aqf "name=yukinator" ', returnStdout: true)

    if(isRunning){
        sh 'docker ps -f name=yukinator -q | xargs --no-run-if-empty docker container stop'
        sh 'docker container ls -a -fname=yukinator -q | xargs -r docker container rm'
    }
    sh 'docker system prune -f'

}

