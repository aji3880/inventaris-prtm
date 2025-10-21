pipeline {
    agent any

    environment {
        OCP_NAMESPACE = "inventaris-barang"
        APP_NAME      = "inventory-app"
        IMAGE_TAG     = "0.0.1"
        OCP_NAME      = "https://api.cluster-f4k2h.dynamic.redhatworkshops.io:6443"
        HELM_CHART_PATH = "helm-chart/"
        HELM_BIN        = "${WORKSPACE}/bin/helm"
        IMAGE_REPO = "image-registry.openshift-image-registry.svc:5000/${OCP_NAMESPACE}/${APP_NAME}:${IMAGE_TAG}"
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
                withCredentials([usernamePassword(credentialsId: 'ocp-crd', usernameVariable: 'OCP_USER', passwordVariable: 'OCP_PASS')]) {
                    sh """
                    oc login -u ${OCP_USER} -p ${OCP_PASS} --server=${OCP_NAME} --insecure-skip-tls-verify=true
                    if ! oc get project ${OCP_NAMESPACE} >/dev/null 2>&1; then
                        oc new-project ${OCP_NAMESPACE} --description="Project for ${APP_NAME}"
                    fi
                    oc project ${OCP_NAMESPACE}
                    """
                }
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
                        mkdir -p "${WORKSPACE}/bin"
                        mv linux-amd64/helm "${WORKSPACE}/bin/helm"
                        chmod +x "${WORKSPACE}/bin/helm"
                    else
                        echo "Helm is already installed"
                    fi
                    "${WORKSPACE}/bin/helm" version
                    """
                }
            }
        }

        stage('deploy helm') {
            steps {
                script {
                    sh """
                    echo "Helm binary path: ${HELM_BIN}"
                    ls -l "${WORKSPACE}/bin" || true
                    "${HELM_BIN}" version

                    # Jalankan lint
                    "${HELM_BIN}" lint ./helm-chart

                    # Deploy aplikasi via Helm
                    "${HELM_BIN}" upgrade --install ${APP_NAME} ./helm-chart \
                        --namespace ${OCP_NAMESPACE} --create-namespace \
                        --set serviceAccount.create=true \
                        --set image.repository=${IMAGE_REPO} \
                        --set image.tag=${IMAGE_TAG} \
                        --set env.DB_HOST=${MYSQL_RELEASE}.${OCP_NAMESPACE}.svc.cluster.local \
                        --set env.DB_DATABASE=${APP_NAME}_db \
                        --set env.DB_USERNAME=${APP_NAME}_user \
                        --set env.DB_PASSWORD=pass123

                    # Render manifest untuk verifikasi
                    "${HELM_BIN}" template ${APP_NAME} ./helm-chart \
                        --namespace ${OCP_NAMESPACE} \
                        --set image.repository=${IMAGE_REPO} \
                        --set image.tag=${IMAGE_TAG} > rendered.yaml

                    cat rendered.yaml

                    # Apply ke OpenShift
                    oc apply -f rendered.yaml -n ${OCP_NAMESPACE}

                    # Buat secret app-key
                    oc create secret generic ${APP_NAME}-app-key \
                    --from-literal=APP_KEY=\$(openssl rand -base64 32) \
                    -n ${OCP_NAMESPACE} --dry-run=client -o yaml | oc apply -f -
                    """
                }
            }
        }




        stage('deploy MySQL') {
            steps {
                timeout(time: 30, unit: 'MINUTES') {
                    sh """
                    set -x
                    ./bin/helm pull oci://registry-1.docker.io/bitnamicharts/mysql --version 14.0.3
                    ./bin/helm upgrade --install ${MYSQL_RELEASE} mysql-14.0.3.tgz \
                        --namespace ${OCP_NAMESPACE} --create-namespace \
                        --set auth.rootPassword=admin123 \
                        --set auth.database=${APP_NAME}_db \
                        --set auth.username=${APP_NAME}_user \
                        --set auth.password=pass123 \
                        --set primary.persistence.size=1Gi
                    """
                }
            }
        }

        stage('rollout') {
            steps {
                script {
                    sh """
                    oc rollout restart deployment/inventory-app-inventory-app -n ${OCP_NAMESPACE}
                    """
                }
            }
        }
    }
}
