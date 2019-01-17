<template>
  <div>
    <el-form
      :inline="true"
      :model="form1"
      align="left"
      style="margin-left: 10px; margin-top: 30px;"
      label-position="right"
      label-width="120px">

      <el-form-item label="用户id:">
        <el-input v-model="form1.userId" placeholder="用户id" clearable style="width: 150px"/>
      </el-form-item>

      <el-form-item label="游戏:">
        <el-select v-model="form1.selectGame" style="width: 150px">
          <el-option
            v-for="item in form1.optionsGame"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="处理状态:">
        <el-select v-model="form1.selectHandleStatus" style="width: 150px">
          <el-option
            v-for="item in form1.optionsHandleStatus"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="">
        <el-button type="primary" size="small" icon="el-icon-search" @click="handleGet()">查询</el-button>
      </el-form-item>

    </el-form>

    <!-- 表格1 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'id', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="id" label="举报用户" align="center"/>
      <el-table-column min-width="10%" prop="account" label="金币变化" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="同桌用户" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="举报时间" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="原因" align="center"/>
      <el-table-column min-width="10%" prop="operator" label="游戏" align="center"/>
      <el-table-column min-width="10%" prop="account" label="牌局编号" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="状态" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="操作" align="center">
        <template slot-scope="scope1">
          <el-button type="primary" size="mini">编辑</el-button>
        </template>
      </el-table-column>
    </el-table>

  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
        userId: '',

        selectGame: -1,
        optionsGame: [{
          label: '全部',
          value: -1
        }],

        selectHandleStatus: -1,
        optionsHandleStatus: [{
          label: '全部',
          value: -1
        }]
      },

      tableData: [{
        id: '11'
      }]
    }
  },

  created() {

  },

  methods: {

    // 添加游戏版本
    handleAdd() {

    }
  }
}
</script>
