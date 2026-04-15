document.addEventListener('DOMContentLoaded', function () {
    const themeBtns = document.querySelectorAll('.themeBtn');
    const mainContent = document.querySelector('.mainContent');

    themeBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            themeBtns.forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');

            var theme = btn.getAttribute('data-theme');
            if (!mainContent) return;
            mainContent.style.backgroundColor = theme === 'light' ? '#eeeeee' : '#050610';
        });
    });

    const canvas = document.getElementById('mainShaderBg');
    if (!canvas || !mainContent) return;

    const gl = canvas.getContext('webgl');
    if (!gl) return;

    /* ── Helpers ── */
    function createShader(type, source) {
        var s = gl.createShader(type);
        gl.shaderSource(s, source);
        gl.compileShader(s);
        if (!gl.getShaderParameter(s, gl.COMPILE_STATUS)) {
            console.error(gl.getShaderInfoLog(s));
            gl.deleteShader(s);
            return null;
        }
        return s;
    }

    function createProgram(vs, fs) {
        var p = gl.createProgram();
        gl.attachShader(p, vs);
        gl.attachShader(p, fs);
        gl.linkProgram(p);
        if (!gl.getProgramParameter(p, gl.LINK_STATUS)) {
            console.error(gl.getProgramInfoLog(p));
            return null;
        }
        return p;
    }

    /* ═══════════════════════════════════════════════
       PASS 1 — Background gradient + vignette
       (fullscreen quad, zero math per pixel)
       ═══════════════════════════════════════════════ */

    var bgVS = createShader(gl.VERTEX_SHADER, [
        'attribute vec2 a_position;',
        'void main(){ gl_Position = vec4(a_position, 0.0, 1.0); }'
    ].join('\n'));

    var bgFS = createShader(gl.FRAGMENT_SHADER, [
        'precision mediump float;',
        'uniform vec2 u_resolution;',
        'void main(){',
        '  vec2 uv = gl_FragCoord.xy / u_resolution;',
        '  float grad = pow(uv.y, 0.8);',
        '  vec3 col = mix(vec3(0.02), vec3(0.82, 0.82, 0.83), grad);',
        '  float vig = 1.0 - 0.3 * length((uv - 0.5) * 1.4);',
        '  col *= vig;',
        '  gl_FragColor = vec4(col, 1.0);',
        '}'
    ].join('\n'));

    if (!bgVS || !bgFS) return;
    var bgProg = createProgram(bgVS, bgFS);
    if (!bgProg) return;

    var bgPosLoc = gl.getAttribLocation(bgProg, 'a_position');
    var bgResLoc = gl.getUniformLocation(bgProg, 'u_resolution');

    var quadBuf = gl.createBuffer();
    gl.bindBuffer(gl.ARRAY_BUFFER, quadBuf);
    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([
        -1, -1, 1, -1, -1, 1, -1, 1, 1, -1, 1, 1
    ]), gl.STATIC_DRAW);

    /* ═══════════════════════════════════════════════
       PASS 2 — Particles as real GL_POINTS
       Noise runs ONLY 64 times (vertex shader)
       instead of width × height × 64 (old fragment)
       ═══════════════════════════════════════════════ */

    var noiseSrc = [
        'vec3 mod289v3(vec3 x){return x-floor(x*(1.0/289.0))*289.0;}',
        'vec2 mod289v2(vec2 x){return x-floor(x*(1.0/289.0))*289.0;}',
        'vec3 permute(vec3 x){return mod289v3(((x*34.0)+1.0)*x);}',
        'float snoise(vec2 v){',
        '  const vec4 C=vec4(0.211324865405187,0.366025403784439,-0.577350269189626,0.024390243902439);',
        '  vec2 i=floor(v+dot(v,C.yy));',
        '  vec2 x0=v-i+dot(i,C.xx);',
        '  vec2 i1=(x0.x>x0.y)?vec2(1.0,0.0):vec2(0.0,1.0);',
        '  vec4 x12=x0.xyxy+C.xxzz; x12.xy-=i1;',
        '  i=mod289v2(i);',
        '  vec3 p=permute(permute(i.y+vec3(0.0,i1.y,1.0))+i.x+vec3(0.0,i1.x,1.0));',
        '  vec3 m=max(0.5-vec3(dot(x0,x0),dot(x12.xy,x12.xy),dot(x12.zw,x12.zw)),0.0);',
        '  m=m*m; m=m*m;',
        '  vec3 xx=2.0*fract(p*C.www)-1.0;',
        '  vec3 h=abs(xx)-0.5;',
        '  vec3 ox=floor(xx+0.5);',
        '  vec3 a0=xx-ox;',
        '  m*=1.79284291400159-0.85373472095314*(a0*a0+h*h);',
        '  vec3 g;',
        '  g.x=a0.x*x0.x+h.x*x0.y;',
        '  g.yz=a0.yz*x12.xz+h.yz*x12.yw;',
        '  return 130.0*dot(m,g);',
        '}',
        'float flowAngle(vec2 p,float t){',
        '  return snoise(p*2.5+t*0.15)*6.2832;',
        '}'
    ].join('\n');

    var particleVertSrc = [
        'attribute vec3 a_particle;',
        'uniform float u_time;',
        'uniform vec2  u_resolution;',
        'uniform float u_maxPointSize;',
        'uniform vec2  u_mouse;',
        'varying float v_brightness;',
        'varying float v_grey;',
        'varying float v_sizeNorm;',
        noiseSrc,
        'void main(){',
        '  float aspect = u_resolution.x / u_resolution.y;',
        '  vec2 pos = a_particle.xy;',
        '  float depth = a_particle.z;',
        '  vec2 center = vec2(0.5, 0.5);',
        '  vec2 toPos = pos - center;',
        '  float angleRot = u_time * 0.2 * (0.5 + depth);',
        '  float cosA = cos(angleRot);',
        '  float sinA = sin(angleRot);',
        '  vec2 rotatedPos = vec2(',
        '    toPos.x * cosA - toPos.y * sinA,',
        '    toPos.x * sinA + toPos.y * cosA',
        '  ) + center;',
        '  vec2 uvPos = rotatedPos;',
        '  vec2 samplePos = vec2(uvPos.x * aspect, uvPos.y);',
        '',
        '  /* D: distort flow field near cursor */',
        '  vec2 mouseAsp = vec2(u_mouse.x * aspect, u_mouse.y);',
        '  float distToMouse = length(samplePos - mouseAsp);',
        '  float influence = smoothstep(0.35, 0.0, distToMouse);',
        '  float angle = flowAngle(samplePos, u_time * 0.5);',
        '  float distortAngle = atan(samplePos.y - mouseAsp.y, samplePos.x - mouseAsp.x);',
        '  angle = mix(angle, distortAngle + 1.5708, influence * 0.8);',
        '',
        '  float spd = 0.008 * (0.5 + 0.5 * depth);',
        '  spd += influence * 0.015;',
        '  uvPos += vec2(cos(angle) / aspect, sin(angle)) * spd;',
        '  uvPos = fract(uvPos);',
        '  vec2 ndc = vec2(uvPos.x * 2.0 - 1.0, uvPos.y * 2.0 - 1.0);',
        '  gl_Position = vec4(ndc, 0.0, 1.0);',
        '',
        '  /* E: boost size & brightness near cursor */',
        '  float sizeMult = 1.0 + influence * 1.5;',
        '  float trail = 0.02 * sizeMult;',
        '  float pointPx = trail * 2.0 * u_resolution.y;',
        '  gl_PointSize = min(pointPx, u_maxPointSize);',
        '  float particleSize = 0.003 * (0.4 + 0.8 * depth) * sizeMult;',
        '  v_sizeNorm = particleSize / trail;',
        '  v_brightness = (0.3 + 0.7 * depth) * (1.0 + influence * 2.0);',
        '  v_grey = mix(0.15, 0.95, uvPos.y * 0.6 + depth * 0.4);',
        '}'
    ].join('\n');

    var particleFragSrc = [
        'precision mediump float;',
        'varying float v_brightness;',
        'varying float v_grey;',
        'varying float v_sizeNorm;',
        'void main(){',
        '  vec2 pc = gl_PointCoord * 2.0 - 1.0;',
        '  float d = length(pc);',
        '  float core = smoothstep(v_sizeNorm, v_sizeNorm * 0.15, d);',
        '  float halo = smoothstep(1.0, 0.0, d) * 0.08 * v_brightness;',
        '  vec3 col = vec3(v_grey) * (core + halo) * v_brightness;',
        '  gl_FragColor = vec4(col, 1.0);',
        '}'
    ].join('\n');

    var pVS = createShader(gl.VERTEX_SHADER, particleVertSrc);
    var pFS = createShader(gl.FRAGMENT_SHADER, particleFragSrc);
    if (!pVS || !pFS) return;
    var pProg = createProgram(pVS, pFS);
    if (!pProg) return;

    var pPartLoc  = gl.getAttribLocation(pProg, 'a_particle');
    var pTimeLoc  = gl.getUniformLocation(pProg, 'u_time');
    var pResLoc   = gl.getUniformLocation(pProg, 'u_resolution');
    var pMaxPSLoc = gl.getUniformLocation(pProg, 'u_maxPointSize');
    var pMouseLoc = gl.getUniformLocation(pProg, 'u_mouse');

    /* ── Mouse tracking (on whole container) ── */
    var mouseUV = [-1.0, -1.0];
    mainContent.addEventListener('mousemove', function (e) {
        var rect = canvas.getBoundingClientRect();
        mouseUV[0] = (e.clientX - rect.left) / rect.width;
        mouseUV[1] = 1.0 - (e.clientY - rect.top) / rect.height;
    });
    mainContent.addEventListener('mouseleave', function () {
        mouseUV[0] = -1.0;
        mouseUV[1] = -1.0;
    });

    /* ── Build 64 particle seeds (runs once) ── */
    var GRID = 8;
    var NUM = GRID * GRID;

    function fract(x) { return x - Math.floor(x); }
    function hash21(ax, ay) {
        var px = fract(ax * 123.34);
        var py = fract(ay * 456.21);
        var d = px * (px + 45.32) + py * (py + 45.32);
        px += d; py += d;
        return fract(px * py);
    }

    var data = new Float32Array(NUM * 3);
    var idx = 0;
    for (var cy = 0; cy < GRID; cy++) {
        for (var cx = 0; cx < GRID; cx++) {
            var sx = cx / GRID, sy = cy / GRID;
            var px = sx + 0.5 / GRID;
            var py = sy + 0.5 / GRID;
            px += (hash21(sx, sy) - 0.5) * 0.6 / GRID;
            py += (hash21(sx + 7.7, sy + 7.7) - 0.5) * 0.6 / GRID;
            var depth = hash21(sx + 3.3, sy + 3.3);
            data[idx++] = px;
            data[idx++] = py;
            data[idx++] = depth;
        }
    }

    var particleBuf = gl.createBuffer();
    gl.bindBuffer(gl.ARRAY_BUFFER, particleBuf);
    gl.bufferData(gl.ARRAY_BUFFER, data, gl.STATIC_DRAW);

    var maxPS = Math.min(gl.getParameter(gl.ALIASED_POINT_SIZE_RANGE)[1], 256.0);

    /* ── Resize ── */
    function resizeCanvas() {
        var rect = mainContent.getBoundingClientRect();
        var dpr = Math.min(window.devicePixelRatio || 1, 1);
        var w = Math.floor(rect.width * dpr);
        var h = Math.floor(rect.height * dpr);
        if (canvas.width !== w || canvas.height !== h) {
            canvas.width = w;
            canvas.height = h;
            canvas.style.width = rect.width + 'px';
            canvas.style.height = rect.height + 'px';
        }
        gl.viewport(0, 0, canvas.width, canvas.height);
    }
    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();

    /* ── Render loop (~30 fps) ── */
    var lastFrame = 0;
    var FRAME_INTERVAL = 1000 / 30;

    function render(time) {
        requestAnimationFrame(render);
        if (time - lastFrame < FRAME_INTERVAL) return;
        lastFrame = time;

        var t = time * 0.001;
        var w = canvas.width, h = canvas.height;

        /* Pass 1 — Background (opaque) */
        gl.disable(gl.BLEND);
        gl.useProgram(bgProg);
        gl.bindBuffer(gl.ARRAY_BUFFER, quadBuf);
        gl.enableVertexAttribArray(bgPosLoc);
        gl.vertexAttribPointer(bgPosLoc, 2, gl.FLOAT, false, 0, 0);
        gl.uniform2f(bgResLoc, w, h);
        gl.drawArrays(gl.TRIANGLES, 0, 6);
        gl.disableVertexAttribArray(bgPosLoc);

        /* Pass 2 — 64 particles (additive blend) */
        gl.enable(gl.BLEND);
        gl.blendFunc(gl.ONE, gl.ONE);
        gl.useProgram(pProg);
        gl.bindBuffer(gl.ARRAY_BUFFER, particleBuf);
        gl.enableVertexAttribArray(pPartLoc);
        gl.vertexAttribPointer(pPartLoc, 3, gl.FLOAT, false, 0, 0);
        gl.uniform1f(pTimeLoc, t);
        gl.uniform2f(pResLoc, w, h);
        gl.uniform1f(pMaxPSLoc, maxPS);
        gl.uniform2f(pMouseLoc, mouseUV[0], mouseUV[1]);
        gl.drawArrays(gl.POINTS, 0, NUM);
        gl.disableVertexAttribArray(pPartLoc);
    }

    requestAnimationFrame(render);
});