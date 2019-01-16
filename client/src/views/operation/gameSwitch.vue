<template>
  <div>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="online" label="渠道id" align="center"/>
      <el-table-column min-width="10%" prop="id" label="渠道名" align="center"/>
      <el-table-column min-width="10%" prop="user_email" label="渠道包名" align="center"/>
      <el-table-column min-width="10%" prop="userIDCardName" label="是否使用默认配置" align="center"/>
      <el-table-column min-width="10%" prop="upLine" label="斗地主普通" align="center"/>
      <el-table-column min-width="10%" prop="upLine" label="斗地主欢乐" align="center"/>
      <el-table-column min-width="10%" prop="upLine" label="斗地主癞子" align="center"/>
      <el-table-column min-width="10%" prop="upLine" label="炸金花" align="center"/>
      <el-table-column min-width="10%" prop="upLine" label="百人炸金花" align="center"/>
      <el-table-column min-width="10%" prop="upLine" label="牛牛" align="center"/>
      <el-table-column min-width="10%" prop="upLine" label="抢庄牛牛" align="center"/>
      <el-table-column min-width="10%" prop="upLine" label="百人牛牛" align="center"/>
      <el-table-column min-width="10%" prop="upLine" label="娱乐城" align="center"/>
      <el-table-column min-width="10%" prop="upLine" label="捕鱼" align="center"/>
      <el-table-column min-width="10%" prop="upLine" label="马来牛牛" align="center"/>
      <el-table-column min-width="10%" prop="upLine" label="十三张" align="center"/>
      <el-table-column min-width="10%" prop="upLine" label="三公" align="center"/>
      <el-table-column min-width="10%" prop="upLine" label="红黑大战" align="center"/>
      <el-table-column min-width="10%" prop="isBlack" label="编辑" align="center">
        <template slot-scope="scope">
          <el-button size="small" type="text" @click="dialogFormEditVisible = true">编辑</el-button>
        </template>
      </el-table-column>

    </el-table>

    <!-- dialogEdit 编辑 -->
    <el-dialog :visible.sync="dialogFormEditVisible" title="修改游戏开关">
      <el-form :model="dialogFormEdit">

        <el-form-item
          :label-width="dialogLabelWidth"
          label="渠道名:"
        >
          <span>xx</span>
        </el-form-item>

        <el-form-item
          :label-width="dialogLabelWidth"
          label="游戏列表:"
        >
          <el-checkbox-group v-model="dialogFormEdit.checkGameList">
            <div><el-checkbox label="-1">使用默认</el-checkbox></div>
            <div><el-checkbox label="1">斗地主</el-checkbox></div>
            <div><el-checkbox label="2">斗地主欢乐</el-checkbox></div>
          </el-checkbox-group>
        </el-form-item>

        <el-form-item align="center">
          <el-button size="small" @click="dialogFormEditVisible = false">取 消</el-button>
          <el-button type="primary" size="small" @click="handleEdit()">确 定</el-button>
        </el-form-item>

      </el-form>
    </el-dialog>

  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
      },

      tableData: [{
        online: 1
      }],

      dialogLabelWidth: '200px',
      dialogFormEditVisible: false,

      dialogFormEdit: {
        checkGameList: ['-1']
      }
    }
  },

  created() {

  },

  methods: {

    handleGet() {

    },

    // 编辑
    handleEdit() {

    }
  }
}
</script>
