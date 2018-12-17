<template>
  <div>
    <el-container>
      <el-header/>
      <el-main>
        <el-row style="text-align: left; margin-bottom:10px;">
          <el-button type="primary">捕鱼游戏</el-button>
          <el-button type="primary">棋牌游戏</el-button>
          <el-button type="primary">电玩街机</el-button>
        </el-row>

        <el-table :data="tableData" stripe="true">
          <el-table-column prop="game" label="游戏名称" align="center"/>
          <el-table-column prop="operation" label="操作" align="center"/>
        </el-table>
      </el-main>
    </el-container>
  </div>
</template>
