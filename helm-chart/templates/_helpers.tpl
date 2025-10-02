{{- define "inventory-app.name" -}}
{{- default .Chart.Name .Values.nameOverride -}}
{{- end -}}

{{- define "inventory-app.chart" -}}
{{- printf "%s-%s" .Chart.Name .Chart.Version -}}
{{- end -}}

{{- define "inventory-app.fullname" -}}
{{- if .Values.fullnameOverride }}
{{ .Values.fullnameOverride }}
{{- else }}
{{- printf "%s-%s" .Release.Name (include "inventory-app.name" .) | trunc 63 }}
{{- end }}
{{- end -}}
