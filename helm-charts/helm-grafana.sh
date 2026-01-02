#!/bin/sh

helm install prometheus prometheus-community/kube-prometheus-stack \
    --namespace monitoring --create-namespace \
    -f monitoring-nodeport.yaml
