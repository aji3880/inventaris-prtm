pipeline {
    agent any

    environment {
        OCP_NAMESPACE = "inventaris-barang"
        APP_NAME      = "inventory"
        IMAGE_TAG     = "0.0.1"
        OCP_NAME      = "https://api.cluster-djc54.dynamic.redhatworkshops.io:6443"
        OCP_TOKEN    = "sha256~2hEskbEVKsj11g3X62B7bBUfcfznJd48juTHY0oNXvs"
        HELM_CHART_PATH = "helm-chart/"
        HELM_BIN        = "${WORKSPACE}/bin/helm"
        IMAGE_REPO = "image-registry.openshift-image-registry.svc:5000/${OCP_NAMESPACE}/${APP_NAME}"

        MYSQL_RELEASE  = "mysql"       // nama release helm
        MYSQL_CHART    = "bitnami/mysql"
        MYSQL_VERSION  = "9.10.0"      // versi chart MySQL
    }

    stages {
        stage('checkout') {
            steps {
                checkout scm
            }
        }

        stage('login ocp') {
            steps {
                sh """
                oc login --token=${OCP_TOKEN} --server=${OCP_NAME} --insecure-skip-tls-verify=true
                if ! oc get project ${OCP_NAMESPACE} >/dev/null 2>&1; then
                    oc new-project ${OCP_NAMESPACE} --description="Project for ${APP_NAME}"
                fi
                oc project ${OCP_NAMESPACE}
                """
            }
        }

        stage('build images') {
            steps {
                script {
                    sh """
                    if oc get bc ${APP_NAME} >/dev/null 2>&1; then
                        oc start-build ${APP_NAME} --from-dir=. --wait --follow
                    else
                        oc new-build --name=${APP_NAME} --binary --strategy=docker
                        oc start-build ${APP_NAME} --from-dir=. --wait --follow
                    fi
                    """
                }
            }
        }

        stage('install helm') {
            steps {
                script {
                    sh """
                    if ! command -v helm &> /dev/null; then
                        curl -sSL https://get.helm.sh/helm-v3.14.4-linux-amd64.tar.gz -o helm.tar.gz
                        tar -zxvf helm.tar.gz
                        mv linux-amd64/helm ${WORKSPACE}/helm
                        chmod +x ./helm
                        export PATH=\$PATH:\$(pwd)
                    else
                        echo "Helm is already installed"
                    fi
                    ./helm version
                    """
                }
            }
        }

       stage('Deploy MySQL') {
            steps {
                sh """
                ${HELM_BIN} repo add bitnami https://charts.bitnami.com/bitnami || true
                ${HELM_BIN} repo update

                ${HELM_BIN} upgrade --install ${MYSQL_RELEASE} ${MYSQL_CHART} \
                --version ${MYSQL_VERSION} \
                --namespace ${OCP_NAMESPACE} --create-namespace \
                --set auth.rootPassword=admin123 \
                --set auth.database=${APP_NAME}_db \
                --set auth.username=${APP_NAME}_user \
                --set auth.password=pass123 \
                --set primary.persistence.size=1Gi
                """
            }
        }

        stage('deploy helm') {
            steps {
                script {
                    sh """
                    ./helm lint ./helm-chart
                    ./helm upgrade --install ${APP_NAME} ./helm-chart --namespace ${OCP_NAMESPACE} \
                        --namespace ${OCP_NAMESPACE} --create-namespace \
                        --set serviceAccount.create=true \
                        --set image.repository=${IMAGE_REPO} \
                        --set image.tag=${IMAGE_TAG} \
                        --set env.DB_HOST=${MYSQL_RELEASE}.${OCP_NAMESPACE}.svc.cluster.local \
                        --set env.DB_DATABASE=${APP_NAME}_db \
                        --set env.DB_USERNAME=${APP_NAME}_user \
                        --set env.DB_PASSWORD=pass123
                    ./helm template ${APP_NAME} ./helm-chart --namespace ${OCP_NAMESPACE} \
                        --set image.repository=${IMAGE_REPO} \
                        --set image.tag=${IMAGE_TAG} > rendered.yaml
                    cat rendered.yaml
                    oc apply -f rendered.yaml -n ${OCP_NAMESPACE}
                    oc create secret generic ${APP_NAME}-app-key \
                    --from-literal=APP_KEY=$(openssl rand -base64 32) \
                    -n ${OCP_NAMESPACE} --dry-run=client -o yaml | oc apply -f -
                    """
                }
            }
        }

        stage('rollout') {
            steps {
                script {
                    sh """
                    oc rollout restart deployment/${APP_NAME} -n ${OCP_NAMESPACE}
                    """
                }
            }
        }
    }
}
