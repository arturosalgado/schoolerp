<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credencial - {{ $student->name }} {{ $student->last_name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .credential-front {
            position: fixed;

            text-align: center;
        }





        .front-image {
            width:324px;

            display: block;
            max-width: 100%;
            height: auto;
        }
        .credential-back {

            position: fixed;
            cursor: move;
            user-select: none;
            transition: box-shadow 0.2s ease;
        }

        .credential-back:hover {
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .credential-back.dragging {
            /* box-shadow: 0 4px 8px rgba(0,0,0,0.3);*/
            z-index: 1000;
        }

        .back-image {
            width: 324px;

            max-width: 100%;
            height: auto;
        }
        .student-photo {
            position: absolute;
            border: 1px solid white;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.3);
            cursor: move;
            user-select: none;
            transition: box-shadow 0.2s ease;
        }

        .student-photo:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.4);
        }

        .student-photo.dragging {
            box-shadow: 0 8px 16px rgba(0,0,0,0.5);
            z-index: 1000;
        }

        .student-name-draggable,
        .student-enrollment-draggable,
        .career-draggable {
            position: absolute;
            font-weight: bold;
            color: {{ $idCardConfig->color ?? '#333' }};
            font-family: {{ $idCardConfig->font ?? 'Arial' }}, sans-serif;
            font-size: {{ $idCardConfig->size ?? '16' }}px;
            user-select: none;
            transition: box-shadow 0.2s ease;
            padding: 2px 2px;
            border-radius: 3px;
        }

        .student-name-draggable {
            font-size: {{ ($idCardConfig->size ?? 16) + 2 }}px;
        }

        .student-enrollment-draggable {
            font-size: {{ ($idCardConfig->size ?? 16) - 2 }}px;
        }

        .career-draggable {
            font-size: {{ $idCardConfig->size ?? '16' }}px;
        }

        .student-name-draggable:hover,
        .student-enrollment-draggable:hover,
        .career-draggable:hover {
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .student-name-draggable.dragging,
        .student-enrollment-draggable.dragging,
        .career-draggable.dragging {
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            z-index: 1000;
        }

        .drag-handle {
            position: fixed;
            top: 70px;
            right: 20px;
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            z-index: 1001;
        }

        .drag-handle:hover {
            background: #218838;
        }

        .drag-handle.active {
            background: #dc3545;
        }

        .drag-handle.active:hover {
            background: #c82333;
        }

        .reset-button {
            position: fixed;
            top: 110px;
            right: 20px;
            background: #ffc107;
            color: #212529;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            z-index: 1001;
        }

        .reset-button:hover {
            background: #e0a800;
        }









        .no-image {
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 40px;
            color: #6c757d;
            font-style: italic;
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            z-index: 1000;
        }

        .print-button:hover {
            background: #0056b3;
        }

        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }

            .print-button,
            .drag-handle,
            .reset-button,
            .position-info {
                display: none !important;
            }

            .credential-container {
                box-shadow: none;
                border: none;
                margin: 0;
                padding: 0;
            }

            .credential-front {
                position: relative;
                display: block;
                margin-bottom: 0.5in;
                page-break-inside: avoid;
            }

            .credential-back {

                display: block;
                background-color: transparent;
                margin-top: 0;
                page-break-inside: avoid;
            }

            .front-image {
                width: 3.375in !important;
                height: 2.125in !important;
                border: none !important;
                max-width: none !important;
            }

            .back-image {
                width: 3.375in !important;
                height: 2.125in !important;
                border: none !important;
                max-width: none !important;
            }

            .student-photo {
                cursor: default !important;
            }

            .student-name-draggable,
            .student-enrollment-draggable,
            .career-draggable {
                position: absolute;
            }

            /* Remove debug borders in print */
            .front-container {
                border: none !important;
            }
        }

        @media (max-width: 768px) {
            .credential-container {

            }

            /*.student-name {*/
            /*    font-size: 20px;*/
            /*}*/
        }
    </style>
</head>
<body style="margin: 0; padding: 0;background-color: #4f4f4f" x-data="credentialApp()"  >
<button class="print-button" @click="window.print()">🖨️ Imprimir Credencial</button>
<button class="drag-handle"
        @click="toggleDragMode()"
        :class="{ 'active': dragEnabled }"
        x-text="dragEnabled ? '🔒 Bloquear/Guardar Elementos' : '🎯 Posicionar Elementos'">
    🎯 Posicionar Foto
</button>
<button class="reset-button"
        @click="resetPosition()"
        x-show="dragEnabled"
        x-transition>
    🔄 Resetear Posición
</button>


<div class="credential-container" >


    <div class="credential-front" >


        @if($frontImageUrl)
            <div class="front-container" >

                <div class="student-name-draggable"
                     :class="{ 'dragging': isDraggingName }"
                     :style="{
                            left: nameX + 'px',
                            top: nameY + 'px',
                            cursor: dragEnabled ? 'move' : 'default'
                         }"
                     @mousedown="startDragName($event)"
                     @mousemove="dragName($event)"
                     @mouseup="endDragName($event)"
                     @mouseleave="endDragName($event)">
                    {{ $student->name }} {{ $student->last_name }} {{ $student->second_last_name }}
                </div>

                @if($idCardConfig->showEnrollment && $student->enrollment)
                    <div class="student-enrollment-draggable"
                         :class="{ 'dragging': isDraggingEnrollment }"
                         :style="{
                                left: enrollmentX + 'px',
                                top: enrollmentY + 'px',
                                cursor: dragEnabled ? 'move' : 'default'
                             }"
                         @mousedown="startDragEnrollment($event)"
                         @mousemove="dragEnrollment($event)"
                         @mouseup="endDragEnrollment($event)"
                         @mouseleave="endDragEnrollment($event)">
                        {{ $student->enrollment }}
                    </div>
                @endif

                @if($idCardConfig->showProgram)
                    <div class="career-draggable"
                         :class="{ 'dragging': isDraggingCareer }"
                         :style="{
                                left: careerX + 'px',
                                top: careerY + 'px',
                                cursor: dragEnabled ? 'move' : 'default'
                             }"
                         @mousedown="startDragCareer($event)"
                         @mousemove="dragCareer($event)"
                         @mouseup="endDragCareer($event)"
                         @mouseleave="endDragCareer($event)">
                        {{ $student->latestProgram()->name }}
                    </div>
                @endif
                <img src="{{ $frontImageUrl }}" alt="Plantilla frontal" class="front-image" id="frontImage">

                @if($studentPhotoUrl)
                    <img src="{{ $studentPhotoUrl }}"
                         alt="Foto del estudiante"
                         class="student-photo"
                         :class="{ 'dragging': isDragging }"
                         :style="{
                                left: photoX + 'px',
                                top: photoY + 'px',
                                width: '{{ $idCardConfig->photo_width }}px',

                                cursor: dragEnabled ? 'move' : 'default'
                             }"
                         @mousedown="startDrag($event)"
                         @mousemove="drag($event)"
                         @mouseup="endDrag($event)"
                         @mouseleave="endDrag($event)">
                @endif

            </div>
        @else
            <div class="no-image">
                No se ha configurado una plantilla frontal para esta escuela
            </div>
        @endif
    </div>

    <div class="credential-back"
         :class="{ 'dragging': isDraggingBack }"
         :style="{
                top: backTop + 'px',
                cursor: dragEnabled ? 'move' : 'default'
             }"
         @mousedown="startDragBack($event)"
         @mousemove="dragBack($event)"
         @mouseup="endDragBack($event)"
         @mouseleave="endDragBack($event)">

        @if($backImageUrl)
            <img src="{{ $backImageUrl }}" alt="Plantilla trasera" class="back-image">
        @else
            <div class="no-image">
                No se ha configurado una plantilla trasera para esta escuela
            </div>
        @endif
    </div>
</div>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    function credentialApp() {
        return {
            dragEnabled: false,
            isDragging: false,
            isDraggingName: false,
            isDraggingEnrollment: false,
            isDraggingCareer: false,
            isDraggingBack: false,
            photoX: {{ $idCardConfig->photo_x }},
            photoY: {{ $idCardConfig->photo_y }},
            nameX: {{ $idCardConfig->name_x ?? 50 }},
            nameY: {{ $idCardConfig->name_y ?? 100 }},
            enrollmentX: {{ $idCardConfig->enrollment_x ?? 50 }},
            enrollmentY: {{ $idCardConfig->enrollment_y ?? 130 }},
            careerX: {{ $idCardConfig->career_x ?? 50 }},
            careerY: {{ $idCardConfig->career_y ?? 160 }},
            backTop:204,
            startX: 0,
            startY: 0,
            offsetX: 0,
            offsetY: 0,

            init() {
                // Auto-trigger print dialog when page loads
                // setTimeout(() => {
                //     if (confirm('¿Desea imprimir la credencial ahora?')) {
                //        // window.print();
                //     }
                // }, 500);

                // Add document-level mouse events
                document.addEventListener('mousemove', (e) => this.drag(e));
                document.addEventListener('mouseup', (e) => this.endDrag(e));
            },

            toggleDragMode() {
                this.dragEnabled = !this.dragEnabled;
            },

            async resetPosition() {
                try {
                    const response = await fetch('{{ route('credentials.reset-positions', $school->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Update all positions to the reset values
                        this.photoX = data.positions.photo.x;
                        this.photoY = data.positions.photo.y;
                        this.nameX = data.positions.name.x;
                        this.nameY = data.positions.name.y;
                        this.enrollmentX = data.positions.enrollment.x;
                        this.enrollmentY = data.positions.enrollment.y;
                        this.careerX = data.positions.career.x;
                        this.careerY = data.positions.career.y;
                        this.backTop = data.positions.back_top;

                        console.log('Todas las posiciones reseteadas:', data);
                    } else {
                        console.error('Error al resetear posiciones:', data.error);
                        alert('Error al resetear las posiciones: ' + data.error);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error de conexión al resetear las posiciones');
                }
            },

            startDrag(event) {
                if (!this.dragEnabled) return;

                event.preventDefault();
                this.isDragging = true;

                this.startX = event.clientX;
                this.startY = event.clientY;
                this.offsetX = this.photoX;
                this.offsetY = this.photoY;
            },

            drag(event) {
                if (!this.dragEnabled || !this.isDragging) return;

                event.preventDefault();

                const deltaX = event.clientX - this.startX;
                const deltaY = event.clientY - this.startY;

                this.photoX = Math.max(0, this.offsetX + deltaX);
                this.photoY = Math.max(0, this.offsetY + deltaY);
            },

            endDrag(event) {
                if (!this.dragEnabled || !this.isDragging) return;

                this.isDragging = false;
                this.savePosition();
            },

            async savePosition() {
                try {
                    const response = await fetch('{{ route('credentials.update-photo-position', $school->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            x: this.photoX,
                            y: this.photoY
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        console.log('Posición guardada:', data);
                    } else {
                        console.error('Error al guardar posición:', data.error);
                        alert('Error al guardar la posición: ' + data.error);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error de conexión al guardar la posición');
                }
            },

            // Name drag methods
            startDragName(event) {
                if (!this.dragEnabled) return;

                event.preventDefault();
                this.isDraggingName = true;

                this.startX = event.clientX;
                this.startY = event.clientY;
                this.offsetX = this.nameX;
                this.offsetY = this.nameY;
            },

            dragName(event) {
                if (!this.dragEnabled || !this.isDraggingName) return;

                event.preventDefault();

                const deltaX = event.clientX - this.startX;
                const deltaY = event.clientY - this.startY;

                this.nameX = Math.max(0, this.offsetX + deltaX);
                this.nameY = Math.max(0, this.offsetY + deltaY);
            },

            endDragName(event) {
                if (!this.dragEnabled || !this.isDraggingName) return;

                this.isDraggingName = false;
                this.saveTextPosition('name', this.nameX, this.nameY);
            },

            // Enrollment drag methods
            startDragEnrollment(event) {
                if (!this.dragEnabled) return;

                event.preventDefault();
                this.isDraggingEnrollment = true;

                this.startX = event.clientX;
                this.startY = event.clientY;
                this.offsetX = this.enrollmentX;
                this.offsetY = this.enrollmentY;
            },

            dragEnrollment(event) {
                if (!this.dragEnabled || !this.isDraggingEnrollment) return;

                event.preventDefault();

                const deltaX = event.clientX - this.startX;
                const deltaY = event.clientY - this.startY;

                this.enrollmentX = Math.max(0, this.offsetX + deltaX);
                this.enrollmentY = Math.max(0, this.offsetY + deltaY);
            },

            endDragEnrollment(event) {
                if (!this.dragEnabled || !this.isDraggingEnrollment) return;

                this.isDraggingEnrollment = false;
                this.saveTextPosition('enrollment', this.enrollmentX, this.enrollmentY);
            },

            // Career drag methods
            startDragCareer(event) {
                if (!this.dragEnabled) return;

                event.preventDefault();
                this.isDraggingCareer = true;

                this.startX = event.clientX;
                this.startY = event.clientY;
                this.offsetX = this.careerX;
                this.offsetY = this.careerY;
            },

            dragCareer(event) {
                if (!this.dragEnabled || !this.isDraggingCareer) return;

                event.preventDefault();

                const deltaX = event.clientX - this.startX;
                const deltaY = event.clientY - this.startY;

                this.careerX = Math.max(0, this.offsetX + deltaX);
                this.careerY = Math.max(0, this.offsetY + deltaY);
            },

            endDragCareer(event) {
                if (!this.dragEnabled || !this.isDraggingCareer) return;

                this.isDraggingCareer = false;
                this.saveTextPosition('career', this.careerX, this.careerY);
            },

            // Back drag methods
            startDragBack(event) {
                if (!this.dragEnabled) return;

                event.preventDefault();
                this.isDraggingBack = true;

                this.startY = event.clientY;
                this.offsetY = this.backTop;
            },

            dragBack(event) {
                if (!this.dragEnabled || !this.isDraggingBack) return;

                event.preventDefault();

                const deltaY = event.clientY - this.startY;

                this.backTop = Math.max(0, this.offsetY + deltaY);
            },

            endDragBack(event) {
                if (!this.dragEnabled || !this.isDraggingBack) return;

                this.isDraggingBack = false;
                this.saveBackPosition();
            },

            async saveBackPosition() {
                try {
                    const response = await fetch('{{ route('credentials.update-back-position', $school->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            top: this.backTop
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        console.log('Posición del reverso guardada:', data);
                    } else {
                        console.error('Error al guardar posición del reverso:', data.error);
                        alert('Error al guardar la posición del reverso: ' + data.error);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error de conexión al guardar la posición del reverso');
                }
            },

            async saveTextPosition(type, x, y) {
                try {
                    const response = await fetch('{{ route('credentials.update-text-position', $school->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            type: type,
                            x: x,
                            y: y
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        console.log(`Posición de ${type} guardada:`, data);
                    } else {
                        console.error(`Error al guardar posición de ${type}:`, data.error);
                        alert(`Error al guardar la posición de ${type}: ` + data.error);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert(`Error de conexión al guardar la posición de ${type}`);
                }
            }
        }
    }
</script>
</body>
</html>
