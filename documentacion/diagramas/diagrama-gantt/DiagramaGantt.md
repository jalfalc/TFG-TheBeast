```mermaid
gantt
    title Diagrama de Gantt del The Beast Barber
    dateFormat  YYYY-MM-DD
    axisFormat  %W
    tickInterval 1w
    section Fases
    Análisis y diseño          :a1, 2023-01-01, 1.5w
    Desarrollo frontend        :a2, after a1, 2w
    Desarrollo backend         :a3, after a2, 2w
    Pruebas/ajustes  :a4, after a3, 1.5w
    Documentación :a5, after a4, 1w
    Entrega                    :milestone, m1, after a5, 0d
```