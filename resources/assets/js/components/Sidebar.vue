<template>
 <div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li class="nav-title">Navigation</li>

                    <li class="nav-item">
                      <router-link :to="'/'" class="nav-link active">
                            <i class="icon icon-speedometer"></i> Dashboard
                        </router-link>
                    </li>
                    <li class="nav-item">
                       <router-link :to="'/login'" class="nav-link active">
                            <i class="icon icon-speedometer"></i> Login
                        </router-link>
                    </li>                    
                </ul>
            </nav>
        </div> 
</template>
